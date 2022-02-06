<?php

namespace Enam\Acc;

use App\Models\Bill;
use App\Models\BillItem;
use App\Models\BillPaymentItem;
use App\Models\ContactInvoice;
use App\Models\ContactInvoicePaymentItem;
use App\Models\Expense;
use App\Models\ExpenseItem;
use App\Models\Invoice;
use App\Models\MetaSetting;
use App\Models\PosPayment;
use App\Models\PosSale;
use App\Models\PurchaseOrder;
use App\Models\PurchaseReturn;
use App\Models\ReceivePaymentItem;
use App\Models\SalesReturn;
use Carbon\Doctrine\DateTimeDefaultPrecision;
use Enam\Acc\Models\GroupMap;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\Transaction;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Traits\TransactionTrait;
use Enam\Acc\Utils\EntryType;
use Enam\Acc\Utils\LedgerHelper;
use Illuminate\Support\Facades\Facade;
use phpDocumentor\Reflection\Types\This;

/**
 * @see \Enam\Accounting\Skeleton\SkeletonClass
 */
class AccountingFacade extends Facade
{
    use TransactionTrait;

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {

        return 'accounting';

    }

    // Accounting Facade

    public static function addSalary($amount, $note, $date, $type = null, $type_id = null, $bank_name = null, $cheque_number = null, $cheque_date = null)
    {
        $salary_ac_id = GroupMap::query()->where('key', LedgerHelper::$SALARY_AC)->first()->value ?? null;
        self::addTransaction($salary_ac_id, Ledger::CASH_AC(), $amount, $note, $date, 'Salary', $type, $type_id);

    }

    public static function addPurchase($amount, $note, $date, $type = null, $type_id = null, $bank_name = null, $cheque_number = null, $cheque_date = null)
    {
        self::addTransaction(Ledger::PURCHASE_AC(), Ledger::CASH_AC(), $amount, $note, $date, 'Purchase', $type, $type_id);

    }

    public static function addSale($amount, $note, $date, $type = null, $type_id = null, $bank_name = null, $cheque_number = null, $cheque_date = null)
    {

        self::addTransaction(Ledger::CASH_AC(), Ledger::SALES_AC(), $amount, $note, $date, 'Sales', $type, $type_id);


    }

    public static function addServiceRevenue($amount, $note, $date, $type = null, $type_id = null, $bank_name = null, $cheque_number = null, $cheque_date = null)
    {
        $sales_ac_id = GroupMap::query()->where('key', LedgerHelper::$SERVICE_REVENUE_AC)->first()->value ?? null;
        $cash_ac_id = GroupMap::query()->where('key', LedgerHelper::$CASH_AC)->first()->value ?? null;
        self::addTransaction($cash_ac_id, $sales_ac_id, $amount, $note, $date, 'Service Revenue', $type, $type_id);
    }

    public static function addTransaction($dr_ledger_id, $cr_ledger_id, $amount, $note, $date, $txn_type = null, $type = null, $type_id = null, $ref = null, $transaction_detail = null)
    {
        $voucher_no = (new self())->getVoucherID();


        $txn = Transaction::create(['amount' => $amount, 'note' => $note,
            'date' => $date, 'voucher_no' => $voucher_no,
            'txn_type' => $txn_type, 'ledger_name' => optional(Ledger::find($dr_ledger_id))->ledger_name, 'type' => $type, 'type_id' => $type_id
        ]);

        if ($dr_ledger_id) {
            TransactionDetail::create(['transaction_id' => $txn->id, 'ledger_id' => $dr_ledger_id,
                'entry_type' => EntryType::$DR, 'amount' => $amount, 'note' => $note, 'date' => $date,
                'transaction_details' => $transaction_detail, 'ref' => $ref
                , 'type' => $type, 'type_id' => $type_id
            ]);
        }
        if ($cr_ledger_id) {
            TransactionDetail::create(['transaction_id' => $txn->id, 'ledger_id' => $cr_ledger_id,
                'entry_type' => EntryType::$CR, 'amount' => $amount, 'note' => $note, 'date' => $date,
                'transaction_details' => $transaction_detail, 'ref' => $ref
                , 'type' => $type, 'type_id' => $type_id]);
        }


    }

    public
    static function getAllBankAccount()
    {
        $bank_ledgers = (new self())->getBankLedgers();
        $ledgers = Ledger::find($bank_ledgers);
        return $ledgers->pluck('ledger_name', 'id')->toArray();
    }

    public function on_invoice_create(Invoice $invoice)
    {

        /*  Customer - Dr
         *  Sales    - Cr
         *
         *  COGS     - Dr
         *  Inventory- Cr
         *
         *
         *  Sales    10400cr
         *  Customer 5600dr
         *  Cash     4800dr
         *
         *  Customer 5600cr
         *  Cash     5600dr
         *
         *  Customer 10400dr
         *  Sales    10400cr
         *
         *
         * */


        $customer = $invoice->customer;


        self::addTransaction(optional($customer->ledger)->id, Ledger::SALES_AC(), $invoice->total, $invoice->notes,
            $invoice->invoice_date, 'Invoice', Invoice::class, $invoice->id,
            $invoice->invoice_number, optional($invoice->customer)->name);

        /*
         * Cost of Goods Sold Goes here
         * */

        foreach ($invoice->invoice_items as $invoice_item) {
            $product = $invoice_item->product;
            if ($product->product_type != 'Goods') continue;

            $purchase_price = $product->purchase_price ?? 0;
            $cost_of_goods_sold = $purchase_price * $invoice_item->qnt;
            if ($cost_of_goods_sold) {
                self::addTransaction(Ledger::COST_OF_GOODS_SOLD(), Ledger::INVENTORY_AC(), $cost_of_goods_sold, $invoice->notes,
                    $invoice->invoice_date, 'Expense', Invoice::class, $invoice->id,
                    $invoice->invoice_number, LedgerHelper::$COST_OF_GOODS_SOLD);
            }
        }


    }

    public function on_invoice_delete(Invoice $invoice)
    {
        Transaction::query()->where(['type' => Invoice::class, 'type_id' => $invoice->id])->forceDelete();
        TransactionDetail::query()->where(['type' => Invoice::class, 'type_id' => $invoice->id])->forceDelete();
    }

    public function on_invoice_payment_create(ReceivePaymentItem $receivePaymentItem)
    {
        $invoice = $receivePaymentItem->invoice;
        $customer = $invoice->customer;
        /*
         * Cash     - Dr
         * Customer - Cr
         * */

        self::addTransaction($receivePaymentItem->receive_payment->deposit_to, optional($customer->ledger)->id, $receivePaymentItem->amount,
            $receivePaymentItem->receive_payment->note, $receivePaymentItem->receive_payment->payment_date,
            'Customer Payment', ReceivePaymentItem::class, $receivePaymentItem->id,
            $invoice->invoice_number, optional($invoice->customer)->name);
    }

    public function on_invoice_payment_delete(ReceivePaymentItem $receivePaymentItem)
    {
        Transaction::query()->where(['type' => ReceivePaymentItem::class, 'type_id' => $receivePaymentItem->id])->forceDelete();
        TransactionDetail::query()->where(['type' => ReceivePaymentItem::class, 'type_id' => $receivePaymentItem->id])->forceDelete();
    }


    public function on_expense_create(ExpenseItem $expenseItem)
    {
        $name = 'Customer : ' . optional($expenseItem->expense->customer)->name;
        $name .= '\nVendor : ' . optional($expenseItem->expense->vendor)->name;

        self::addTransaction($expenseItem->ledger_id, $expenseItem->expense->ledger_id, $expenseItem->amount, $expenseItem->notes,
            $expenseItem->date, 'Expense', ExpenseItem::class, $expenseItem->id,
            $expenseItem->expense->ref, $name);
    }

    public function on_expense_delete(ExpenseItem $expenseItem)
    {
        Transaction::query()->where(['type' => ExpenseItem::class, 'type_id' => $expenseItem->id])->forceDelete();
        TransactionDetail::query()->where(['type' => ExpenseItem::class, 'type_id' => $expenseItem->id])->forceDelete();
    }


    public function on_bill_create(Bill $bill)
    {
        $vendor = $bill->vendor;
        $amount = $bill->total;

        $settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());
        if (($settings->generate_report_from ?? '') == 'purchase_price_cost_average') {
            $amount = $amount - $bill->charges;
            if ($bill->charges) {
                self::addTransaction(Ledger::PURCHASE_EXPENSE_AC(), null, $bill->charges, $bill->notes,
                    $bill->bill_date, 'Purchase Expense', Bill::class, $bill->id,
                    $bill->bill_number, '');
            }
        }
        self::addTransaction(Ledger::PURCHASE_AC(), optional($vendor->ledger)->id, $amount, $bill->notes,
            $bill->bill_date, 'Bill', Bill::class, $bill->id,
            $bill->bill_number, optional($bill->vendor)->name);

        self::addTransaction(Ledger::INVENTORY_AC(), Ledger::PURCHASE_AC(), $amount, $bill->notes,
            $bill->bill_date, 'Bill', Bill::class, $bill->id,
            $bill->bill_number, optional($bill->vendor)->name);


    }

    public function on_bill_delete(Bill $bill)
    {
        Transaction::query()->where(['type' => Bill::class, 'type_id' => $bill->id])->forceDelete();
        TransactionDetail::query()->where(['type' => Bill::class, 'type_id' => $bill->id])->forceDelete();
    }

    public function on_contact_invoice_create(ContactInvoice $contact_invoice)
    {
        $customer = $contact_invoice->customer;
        self::addTransaction(optional($customer->ledger)->id, Ledger::SALES_AC(), $contact_invoice->total, "Tax Invoice",
            $contact_invoice->invoice_date, 'ContactInvoice', ContactInvoice::class, $contact_invoice->id,
            $contact_invoice->invoice_number, optional($contact_invoice->customer)->name);
    }

    public function on_contact_invoice_delete(ContactInvoice $contact_invoice)
    {
        Transaction::query()->where(['type' => ContactInvoice::class, 'type_id' => $contact_invoice->id])->forceDelete();
        TransactionDetail::query()->where(['type' => ContactInvoice::class, 'type_id' => $contact_invoice->id])->forceDelete();
    }

    public function on_contact_invoice_payment_create(ContactInvoicePaymentItem $receivePaymentItem)
    {
        $invoice = $receivePaymentItem->bill;
        $customer = $invoice->customer;

        self::addTransaction($receivePaymentItem->bill_payment->ledger_id, optional($customer->ledger)->id, $receivePaymentItem->amount,
            $receivePaymentItem->bill_payment->note, $receivePaymentItem->bill_payment->payment_date,
            'Customer Payment', ContactInvoicePaymentItem::class, $receivePaymentItem->id,
            $invoice->invoice_number, optional($invoice->customer)->name);
    }


    public function on_bill_payment_create(BillPaymentItem $billPaymentItem)
    {
        $bill = $billPaymentItem->bill;
        $vendor = $bill->vendor;
        $paidAmount = $billPaymentItem->amount; // 400

        $due = $bill->total - BillPaymentItem::query()
                ->where('id', '!=', $billPaymentItem->id)
                ->where('bill_id', $bill->id)
                ->sum('amount');

        $dueAmount = $due - $bill->charges; // 600 - 100 = 500
//        dd($dueAmount);
        $remains = 0;
        $amountForBill = 0;
        if ($paidAmount > $dueAmount && ($settings->generate_report_from ?? '') == 'purchase_price_cost_average') { // 400 > 500
            $remains = $paidAmount - $dueAmount;
            $amountForBill = $dueAmount;
        } else {
            $amountForBill = $paidAmount;
        }

        self::addTransaction(optional($vendor->ledger)->id, $billPaymentItem->bill_payment->ledger_id,
            $amountForBill, $billPaymentItem->bill_payment->note, $billPaymentItem->bill_payment->payment_date,
            'Vendor Payment', BillPaymentItem::class, $billPaymentItem->id,
            $bill->bill_number, optional($bill->vendor)->name);

        if (($settings->generate_report_from ?? '') == 'purchase_price_cost_average' && $remains > 0) {
            if ($bill->charges > 0) {
                self::addTransaction(null, $billPaymentItem->bill_payment->ledger_id, $remains,
                    $billPaymentItem->bill_payment->note,
                    $billPaymentItem->bill_payment->payment_date,
                    'Purchase Expense',
                    BillPaymentItem::class, $billPaymentItem->id,
                    $bill->bill_number, '');
            }
        }

    }

    public function on_bill_payment_delete($billPaymentItem)
    {
        Transaction::query()->where(['type' => get_class($billPaymentItem), 'type_id' => $billPaymentItem->id])->forceDelete();
        TransactionDetail::query()->where(['type' => get_class($billPaymentItem), 'type_id' => $billPaymentItem->id])->forceDelete();
    }


    public function on_pos_sales_create(PosSale $posSale)
    {

        self::addTransaction(optional($posSale->customer->ledger)->id, Ledger::SALES_AC(), $posSale->total, $posSale->note,
            $posSale->date, 'POS Sale', PosSale::class, $posSale->id,
            $posSale->pos_number, optional($posSale->customer)->name);

        /*
         * Cost of Goods Sold Goes here
         * */

        foreach ($posSale->pos_items as $pos_item) {
            $product = $pos_item->product;
            if ($product->product_type != 'Goods') continue;

            $purchase_price = $product->purchase_price ?? 0;
            if ($purchase_price == 0) {
                $last_bill = BillItem::query()->where('product_id', $pos_item->product_id)->latest()->first();
                if ($last_bill) {
                    $purchase_price = $last_bill->price;
                }
            }
            $cost_of_goods_sold = $purchase_price * $pos_item->qnt;
            if ($cost_of_goods_sold) {
                self::addTransaction(Ledger::COST_OF_GOODS_SOLD(), Ledger::INVENTORY_AC(), $cost_of_goods_sold, $posSale->note,
                    $posSale->date, 'Expense', PosSale::class, $posSale->id,
                    $posSale->pos_number, LedgerHelper::$COST_OF_GOODS_SOLD);
            }
        }


    }

    public function on_pos_sales_delete(PosSale $posSale)
    {
        Transaction::query()->where(['type' => PosSale::class, 'type_id' => $posSale->id])->forceDelete();
        TransactionDetail::query()->where(['type' => PosSale::class, 'type_id' => $posSale->id])->forceDelete();
    }

    public function on_pos_payment_create(PosPayment $posPayment)
    {
        $pos_sale = $posPayment->pos_sale;
        $customer = $pos_sale->customer;
        self::addTransaction($posPayment->ledger_id, optional($customer->ledger)->id, $posPayment->amount,
            $pos_sale->note, $posPayment->date,
            'POS Payment', PosPayment::class, $posPayment->id,
            $pos_sale->pos_number, optional($pos_sale->customer)->name);
    }

    public function on_pos_payment_delete(PosPayment $posPayment)
    {
        Transaction::query()->where(['type' => PosPayment::class, 'type_id' => $posPayment->id])->forceDelete();
        TransactionDetail::query()->where(['type' => PosPayment::class, 'type_id' => $posPayment->id])->forceDelete();
    }


    public function on_purchase_order_payment_create(PurchaseOrder $purchase_order)
    {
        $vendor = $purchase_order->vendor;
        self::addTransaction(optional($vendor->ledger)->id, $purchase_order->deposit_to, $purchase_order->payment_amount,
            $purchase_order->notes, $purchase_order->purchase_order_date,
            'Purchase Order Payment', PurchaseOrder::class, $purchase_order->id,
            $purchase_order->purchase_order_number, optional($purchase_order->vendor)->name);
    }

    public function on_purchase_order_payment_delete(PurchaseOrder $purchase_order)
    {
        Transaction::query()->where(['type' => PurchaseOrder::class, 'type_id' => $purchase_order->id])->forceDelete();
        TransactionDetail::query()->where(['type' => PurchaseOrder::class, 'type_id' => $purchase_order->id])->forceDelete();
    }


    public function on_sales_return_create(SalesReturn $salesReturn)
    {

        $sales_opposite_ledger = $salesReturn->deposit_to;


        $invoice = Invoice::query()->firstWhere('invoice_number', $salesReturn->invoice_number);
        $pos = PosSale::query()->firstWhere('pos_number', $salesReturn->invoice_number);
        if ($invoice == null) {
            $invoice = $pos;
        }
        if (!$salesReturn->is_payment) {
            $sales_opposite_ledger = optional($invoice->customer->ledger)->id;
        }
//         dd($invoice->customer->ledger->id,$sales_opposite_ledger,$salesReturn->toArray());
        self::addTransaction(Ledger::SALES_AC(), $sales_opposite_ledger, $salesReturn->total, $salesReturn->notes,
            $salesReturn->date, 'Sales Return', SalesReturn::class, $salesReturn->id,
            $salesReturn->sales_return_number, optional($salesReturn->customer)->name);

        /*
         *
         * Cost of Goods Sold Goes here
         *
         * */

        foreach ($salesReturn->invoice_items as $invoice_item) {
            $product = $invoice_item->product;
            if ($product->product_type != 'Goods') continue;

            $purchase_price = $product->purchase_price ?? 0;
            if ($purchase_price == 0) {
                $last_bill = BillItem::query()->where('product_id', $invoice_item->product_id)->latest()->first();
                if ($last_bill) {
                    $purchase_price = $last_bill->price;
                }
            }
            $cost_of_goods_sold = $purchase_price * $invoice_item->qnt;
            if ($cost_of_goods_sold) {
                self::addTransaction(Ledger::INVENTORY_AC(), Ledger::COST_OF_GOODS_SOLD(), $cost_of_goods_sold, $salesReturn->notes,
                    $salesReturn->date, 'Sales Return', SalesReturn::class, $salesReturn->id,
                    $salesReturn->sales_return_number, LedgerHelper::$COST_OF_GOODS_SOLD);
            }
        }


    }


    public function on_sales_return_payment_delete(SalesReturn $salesReturn)
    {

        Transaction::query()->where(['type' => SalesReturn::class, 'type_id' => $salesReturn->id])->forceDelete();
        TransactionDetail::query()->where(['type' => SalesReturn::class, 'type_id' => $salesReturn->id])->forceDelete();

    }

    public function on_purchase_return_create(PurchaseReturn $purchaseReturn)
    {

        $sales_opposite_ledger = $purchaseReturn->deposit_to;
        $invoice = Bill::find($purchaseReturn->bill_number);

        if ($invoice->due >= $purchaseReturn->total) {
            $sales_opposite_ledger = optional($invoice->vendor->ledger)->id;
        }
        self::addTransaction($sales_opposite_ledger, Ledger::PURCHASE_AC(), $purchaseReturn->payment_amount, $purchaseReturn->notes,
            $purchaseReturn->date, 'Purchase Return', PurchaseReturn::class, $purchaseReturn->id,
            $purchaseReturn->purchase_return_number, optional($purchaseReturn->vendor)->name);

        /*
         *
         * Cost of Goods Sold Goes here
         *
         * */

        foreach ($purchaseReturn->bill_items as $invoice_item) {
            $product = $invoice_item->product;
            if ($product->product_type != 'Goods') continue;

            $purchase_price = $product->purchase_price ?? 0;
            if ($purchase_price == 0) {
                $last_bill = BillItem::query()->where('product_id', $invoice_item->product_id)->latest()->first();
                if ($last_bill) {
                    $purchase_price = $last_bill->price;
                }
            }
            $cost_of_goods_sold = $purchase_price * $invoice_item->qnt;
            if ($cost_of_goods_sold) {
                self::addTransaction(Ledger::COST_OF_GOODS_SOLD(), Ledger::INVENTORY_AC(), $cost_of_goods_sold, $purchaseReturn->notes,
                    $purchaseReturn->date, 'Expense', PurchaseReturn::class, $purchaseReturn->id,
                    $purchaseReturn->purchase_return_number, LedgerHelper::$COST_OF_GOODS_SOLD);
            }
        }


    }


    public function on_purchase_return_delete(PurchaseReturn $purchaseReturn)
    {
        Transaction::query()->where(['type' => PurchaseReturn::class, 'type_id' => $purchaseReturn->id])->forceDelete();
        TransactionDetail::query()->where(['type' => PurchaseReturn::class, 'type_id' => $purchaseReturn->id])->forceDelete();
    }

}

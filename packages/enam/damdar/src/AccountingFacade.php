<?php

namespace Enam\Acc;

use App\Models\Bill;
use App\Models\BillItem;
use App\Models\BillPaymentItem;
use App\Models\Expense;
use App\Models\ExpenseItem;
use App\Models\Invoice;
use App\Models\ReceivePaymentItem;
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
        $cash_ac_id = GroupMap::query()->where('key', LedgerHelper::$CASH_AC)->first()->value ?? null;
        self::addTransaction($salary_ac_id, $cash_ac_id, $amount, $note, $date, 'Salary', $type, $type_id);

    }

    public static function addPurchase($amount, $note, $date, $type = null, $type_id = null, $bank_name = null, $cheque_number = null, $cheque_date = null)
    {
        $purchase_ac_id = GroupMap::query()->where('key', LedgerHelper::$PURCHASE_AC)->first()->value ?? null;
        $cash_ac_id = GroupMap::query()->where('key', LedgerHelper::$CASH_AC)->first()->value ?? null;
        self::addTransaction($purchase_ac_id, $cash_ac_id, $amount, $note, $date, 'Purchase', $type, $type_id);

    }

    public static function addSale($amount, $note, $date, $type = null, $type_id = null, $bank_name = null, $cheque_number = null, $cheque_date = null)
    {
        $sales_ac_id = GroupMap::query()->where('key', LedgerHelper::$SALES_AC)->first()->value ?? null;
        $cash_ac_id = GroupMap::query()->where('key', LedgerHelper::$CASH_AC)->first()->value ?? null;
        self::addTransaction($cash_ac_id, $sales_ac_id, $amount, $note, $date, 'Sales', $type, $type_id);


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

        TransactionDetail::create(['transaction_id' => $txn->id, 'ledger_id' => $dr_ledger_id,
            'entry_type' => EntryType::$DR, 'amount' => $amount, 'note' => $note, 'date' => $date,
            'transaction_details' => $transaction_detail, 'ref' => $ref
            , 'type' => $type, 'type_id' => $type_id
        ]);

        TransactionDetail::create(['transaction_id' => $txn->id, 'ledger_id' => $cr_ledger_id,
            'entry_type' => EntryType::$CR, 'amount' => $amount, 'note' => $note, 'date' => $date,
            'transaction_details' => $transaction_detail, 'ref' => $ref
            , 'type' => $type, 'type_id' => $type_id]);
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
        $accounts_receivable_ledger = GroupMap::query()->where('key', LedgerHelper::$ACCOUNTS_RECEIVABLE)->first()->value ?? null;
        $sales_ledger = GroupMap::query()->where('key', LedgerHelper::$SALES_AC)->first()->value ?? null;
        self::addTransaction($accounts_receivable_ledger, $sales_ledger, $invoice->total, $invoice->notes,
            $invoice->invoice_date, 'Invoice', Invoice::class, $invoice->id,
            $invoice->invoice_number, optional($invoice->customer)->name);

        /*
         * Cost of Goods Sold Goes here
         * */

        foreach ($invoice->invoice_items as $invoice_item) {
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
                $cogs_ledger = GroupMap::query()->where('key', LedgerHelper::$COST_OF_GOODS_SOLD)->first()->value ?? null;
                $inventory_ledger = GroupMap::query()->where('key', LedgerHelper::$INVENTORY_AC)->first()->value ?? null;
                self::addTransaction($cogs_ledger, $inventory_ledger, $cost_of_goods_sold, $invoice->notes,
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
        $accounts_receivable_ledger = GroupMap::query()->where('key', LedgerHelper::$ACCOUNTS_RECEIVABLE)->first()->value ?? null;

        self::addTransaction($receivePaymentItem->receive_payment->deposit_to, $accounts_receivable_ledger, $receivePaymentItem->amount,
            $receivePaymentItem->receive_payment->notes, $receivePaymentItem->receive_payment->payment_date,
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
        $name .= '\n Vendor : ' . optional($expenseItem->expense->vendor)->name;

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
        $accounts_payable_ledger = GroupMap::query()->where('key', LedgerHelper::$ACCOUNTS_PAYABLE)->first()->value ?? null;
        $purchase_ledger = GroupMap::query()->where('key', LedgerHelper::$PURCHASE_AC)->first()->value ?? null;
        self::addTransaction($purchase_ledger, $accounts_payable_ledger, $bill->total, $bill->notes,
            $bill->bill_date, 'Invoice', Bill::class, $bill->id,
            $bill->bill_number, optional($bill->vendor)->name);

        $inventory_ledger = GroupMap::query()->where('key', LedgerHelper::$INVENTORY_AC)->first()->value ?? null;
        $purchase_ledger = GroupMap::query()->where('key', LedgerHelper::$PURCHASE_AC)->first()->value ?? null;
        self::addTransaction($inventory_ledger, $purchase_ledger, $bill->total, $bill->notes,
            $bill->bill_date, 'Invoice', Bill::class, $bill->id,
            $bill->bill_number, optional($bill->vendor)->name);
    }

    public function on_bill_delete(Bill $bill)
    {
        Transaction::query()->where(['type' => Bill::class, 'type_id' => $bill->id])->forceDelete();
        TransactionDetail::query()->where(['type' => Bill::class, 'type_id' => $bill->id])->forceDelete();
    }


    public function on_bill_payment_create(BillPaymentItem $billPaymentItem)
    {
        $bill = $billPaymentItem->bill;
        $accounts_payable_ledger = GroupMap::query()->where('key', LedgerHelper::$ACCOUNTS_PAYABLE)->first()->value ?? null;

        self::addTransaction($accounts_payable_ledger, $billPaymentItem->bill_payment->ledger_id, $billPaymentItem->amount,
            $billPaymentItem->bill_payment->notes, $billPaymentItem->bill_payment->payment_date,
            'Vendor Payment', BillPaymentItem::class, $billPaymentItem->id,
            $bill->bill_number, optional($bill->vendor)->name);
    }

    public function on_bill_payment_delete(BillPaymentItem $billPaymentItem)
    {
        Transaction::query()->where(['type' => BillPaymentItem::class, 'type_id' => $billPaymentItem->id])->forceDelete();
        TransactionDetail::query()->where(['type' => BillPaymentItem::class, 'type_id' => $billPaymentItem->id])->forceDelete();
    }


}

<?php

namespace Enam\Acc;

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
        self::addTransaction($salary_ac_id, $cash_ac_id, $amount, $note, $date, 'Salary', $type, $type_id, $bank_name, $cheque_number, $cheque_date);

    }

    public static function addPurchase($amount, $note, $date, $type = null, $type_id = null, $bank_name = null, $cheque_number = null, $cheque_date = null)
    {
        $purchase_ac_id = GroupMap::query()->where('key', LedgerHelper::$PURCHASE_AC)->first()->value ?? null;
        $cash_ac_id = GroupMap::query()->where('key', LedgerHelper::$CASH_AC)->first()->value ?? null;
        self::addTransaction($purchase_ac_id, $cash_ac_id, $amount, $note, $date, 'Purchase', $type, $type_id, $bank_name, $cheque_number, $cheque_date);

    }

    public static function addSale($amount, $note, $date, $type = null, $type_id = null, $bank_name = null, $cheque_number = null, $cheque_date = null)
    {
        $sales_ac_id = GroupMap::query()->where('key', LedgerHelper::$SALES_AC)->first()->value ?? null;
        $cash_ac_id = GroupMap::query()->where('key', LedgerHelper::$CASH_AC)->first()->value ?? null;
        self::addTransaction($cash_ac_id, $sales_ac_id, $amount, $note, $date, 'Sales', $type, $type_id, $bank_name, $cheque_number, $cheque_date);


    }

    public static function addServiceRevenue($amount, $note, $date, $type = null, $type_id = null, $bank_name = null, $cheque_number = null, $cheque_date = null)
    {
        $sales_ac_id = GroupMap::query()->where('key', LedgerHelper::$SERVICE_REVENUE_AC)->first()->value ?? null;
        $cash_ac_id = GroupMap::query()->where('key', LedgerHelper::$CASH_AC)->first()->value ?? null;
        self::addTransaction($cash_ac_id, $sales_ac_id, $amount, $note, $date, 'Service Revenue', $type, $type_id, $bank_name, $cheque_number, $cheque_date);
    }

    public static function addTransaction($dr_ledger_id, $cr_ledger_id, $amount, $note, $date, $txn_type = null, $type = null, $type_id = null, $bank_name = null, $cheque_number = null, $cheque_date = null)
    {
        $voucher_no = (new self())->getVoucherID();


        $txn = Transaction::create(['amount' => $amount, 'note' => $note,
            'date' => $date, 'voucher_no' => $voucher_no,
            'txn_type' => $txn_type, 'ledger_name' => optional(Ledger::find($dr_ledger_id))->ledger_name]);

        TransactionDetail::create(['transaction_id' => $txn->id, 'ledger_id' => $dr_ledger_id,
            'entry_type' => EntryType::$DR, 'amount' => $amount, 'note' => $note, 'date' => $date,
            'cheque_number' => $cheque_number, 'cheque_date' => $cheque_date, 'bank_name' => $bank_name, 'is_bank' => $bank_name != null]);

        TransactionDetail::create(['transaction_id' => $txn->id, 'ledger_id' => $cr_ledger_id,
            'entry_type' => EntryType::$CR, 'amount' => $amount, 'note' => $note, 'date' => $date]);
    }

    public
    static function getAllBankAccount()
    {
        $bank_ledgers = (new self())->getBankLedgers();
        $ledgers = Ledger::find($bank_ledgers);
        return $ledgers->pluck('ledger_name', 'id')->toArray();
    }

}

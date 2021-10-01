<?php

namespace App\Models;

use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Utils\EntryType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    const WALK_IN_CUSTOMER = "Walk In Customer";

    protected $guarded = [];

    public function getAddressAttribute()
    {

    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('scopeClient', function (Builder $builder) {
            if (optional(auth()->user())->client_id) {
                $builder->where('client_id', auth()->user()->client_id ?? -1);
            }
        });
    }


    public function ledger()
    {
        return Ledger::query()->where('type', Customer::class)
            ->where('type_id', $this->id)
            ->first();
    }

    public function getPreviousDueAttribute()
    {
        $debit = TransactionDetail::query()
            ->where('type', Customer::class)
            ->where('type_id', $this->id)
            ->where('entry_type', EntryType::$DR)
            ->where('ledger_id',Ledger::ACCOUNTS_RECEIVABLE())
            ->sum('amount');
        $credit = TransactionDetail::query()
            ->where('type', Customer::class)
            ->where('type_id', $this->id)
            ->where('ledger_id',Ledger::ACCOUNTS_RECEIVABLE())
            ->where('entry_type', EntryType::$CR)
            ->sum('amount');
//        dd($debit,$credit);
        return $debit - $credit;
    }

    public function getReceivablesAttribute()
    {

        $due = Invoice::query()->where('customer_id', $this->id)->get()->sum('due');


        $balance = $this->previous_due + $due;
        return $balance;
    }


}

<?php

namespace App\Models;

use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Utils\EntryType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vendors';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('scopeClient', function (Builder $builder) {
            if (optional(auth()->user())->client_id) {
                $builder->where('client_id', auth()->user()->client_id ?? -1);
            }
        });
    }

    public function getPreviousDueAttribute()
    {
        $debit = TransactionDetail::query()
            ->where('type', Vendor::class)
            ->where('type_id', $this->id)
            ->where('entry_type', EntryType::$DR)
            ->where('ledger_id', Ledger::ACCOUNTS_PAYABLE())
            ->sum('amount');
        $credit = TransactionDetail::query()
            ->where('type', Vendor::class)
            ->where('type_id', $this->id)
            ->where('ledger_id', Ledger::ACCOUNTS_PAYABLE())
            ->where('entry_type', EntryType::$CR)
            ->sum('amount');
//        dd($debit,$credit);
        return $credit - $debit;
    }

    public function getPayablesAttribute()
    {

        $due = Bill::query()->where('vendor_id', $this->id)->get()->sum('due');
        $balance = $this->previous_due + $due;
        return $balance;
    }


}

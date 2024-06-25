<?php

namespace Enam\Acc\Models;

use Enam\Acc\Utils\LedgerHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LedgerGroup extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ledger_groups';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_name',
        'parent',
        'nature',
        'cashflow_type',
        'is_default'
    ];

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

        static::creating(function ($ledgerGroup) {
            if (!$ledgerGroup->group_name) {
                $ledgerGroup->group_name = 'Bank Accounts';
            }
        });

        static::updating(function ($ledgerGroup) {
            if (!$ledgerGroup->group_name) {
                $ledgerGroup->group_name = 'Bank Accounts';
            }
        });
    }

    public function under()
    {
        return parent::find($this->parent)->group_name ?? 'Primary';
    }

    public function ledgers()
    {
        return $this->hasMany(Ledger::class);
    }

    public static function ASSETS()
    {
        return GroupMap::query()->where('key', LedgerHelper::$CurrentAsset)->first()->value ?? null;
    }

    public static function BANKS()
    {
        return GroupMap::query()->where('key', LedgerHelper::$BANK_ACCOUNTS)->first()->value ?? null;
    }

    public static function LIABILITIES()
    {
        return GroupMap::query()->where('key', LedgerHelper::$CURRENT_LIABILITIES)->first()->value ?? null;
    }

}

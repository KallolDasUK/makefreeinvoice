<?php

namespace Enam\Acc\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;


    protected $guarded = [];


    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function transaction_details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');

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


}

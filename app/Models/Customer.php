<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{


    protected $fillable = [
        'name',
        'photo',
        'company_name',
        'phone',
        'email',
        'country',
        'address',
        'street_1',
        'street_2',
        'city',
        'state',
        'zip_post',
        'website'
    ];

    public function getAddressAttribute()
    {

    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('scopeClient', function (Builder $builder) {
            if (optional(auth()->user())->client_id){
                $builder->where('client_id', auth()->user()->client_id ?? -1);
            }
        });
    }
}

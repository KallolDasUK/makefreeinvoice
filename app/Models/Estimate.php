<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{


    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function estimate_items()
    {
        return $this->hasMany('App\Models\EstimateItem', 'estimate_id');
    }

    public function estimate_extra()
    {
        return $this->hasMany('App\Models\EstimateExtraField', 'estimate_id');
    }

    public function getExtraFieldsAttribute()
    {
        return ExtraField::query()->where('type', Estimate::class)->where('type_id', $this->id)->get();
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

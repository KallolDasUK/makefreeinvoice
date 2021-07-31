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
    public function getTaxesAttribute()
    {
        $taxes = [];
        $tax_id = [];
        foreach ($this->estimate_items as $invoice_item) {
            $invoice_item->tax = 0;
            if ($invoice_item->tax_id) {
                $tax = Tax::find($invoice_item->tax_id);
                if ($tax) {
                    $taxAmount = (floatval($tax->value) / 100) * $invoice_item->amount;
                    if (in_array($tax->id, $tax_id)) {
                        $taxes[$tax->id]['tax_amount'] += $taxAmount;
                        continue;
                    }
                    $taxes[$tax->id] = ['tax_id' => $tax->id, 'tax_name' => $tax->name.'('.$tax->value.'%)', 'tax_amount' => $taxAmount];
                    $tax_id[] = $tax->id;

                }
            }

        }
        return $taxes;
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

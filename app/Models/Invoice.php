<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{


    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function invoice_items()
    {
        return $this->hasMany('App\Models\InvoiceItem', 'invoice_id');
    }

    public function extra_fields()
    {
        return $this->hasMany('App\Models\ExtraField', 'invoice_id');
    }

    public function getExtraFieldsAttribute()
    {
        return ExtraField::query()->where('type', Invoice::class)->where('type_id', $this->id)->get();
    }


}

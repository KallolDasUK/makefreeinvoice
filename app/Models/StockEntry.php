<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StockEntry extends Model
{


    protected $table = 'stock_entries';


    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }

    public function items()
    {
        return $this->hasMany(StockEntryItem::class, 'stock_entry_id');
    }


    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }


    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }


    protected $guarded = [];

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

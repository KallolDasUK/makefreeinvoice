<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{

    protected $guarded = [];

    public function production_items()
    {
        return $this->hasMany(ProductionItem::class, 'production_id');
    }

    public function used_items()
    {
        return $this->hasMany(IngredientItem::class, 'production_id');
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

    public static function nextRef($increment = 1)
    {
        $next_invoice = 'PROD-' . str_pad(count(self::query()->get()) + $increment, 4, '0', STR_PAD_LEFT);
        if (self::query()->where('ref', $next_invoice)->exists()) {
            return self::nextRef($increment + 1);
        }
        return $next_invoice;
    }
}

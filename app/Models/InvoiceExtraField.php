<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InvoiceExtraField
 *
 * @property int $id
 * @property string|null $invoice_id
 * @property string|null $name
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $client_id
 * @method static Builder|InvoiceExtraField newModelQuery()
 * @method static Builder|InvoiceExtraField newQuery()
 * @method static Builder|InvoiceExtraField query()
 * @method static Builder|InvoiceExtraField whereClientId($value)
 * @method static Builder|InvoiceExtraField whereCreatedAt($value)
 * @method static Builder|InvoiceExtraField whereId($value)
 * @method static Builder|InvoiceExtraField whereInvoiceId($value)
 * @method static Builder|InvoiceExtraField whereName($value)
 * @method static Builder|InvoiceExtraField whereUpdatedAt($value)
 * @method static Builder|InvoiceExtraField whereUserId($value)
 * @method static Builder|InvoiceExtraField whereValue($value)
 * @mixin \Eloquent
 */
class InvoiceExtraField extends Model
{
    use HasFactory;

    protected $guarded = [];
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

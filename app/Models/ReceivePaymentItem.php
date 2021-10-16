<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ReceivePaymentItem
 *
 * @property int $id
 * @property int|null $receive_payment_id
 * @property int|null $invoice_id
 * @property string|null $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read \App\Models\Invoice|null $invoice
 * @property-read \App\Models\ReceivePayment|null $receive_payment
 * @method static Builder|ReceivePaymentItem newModelQuery()
 * @method static Builder|ReceivePaymentItem newQuery()
 * @method static Builder|ReceivePaymentItem query()
 * @method static Builder|ReceivePaymentItem whereAmount($value)
 * @method static Builder|ReceivePaymentItem whereClientId($value)
 * @method static Builder|ReceivePaymentItem whereCreatedAt($value)
 * @method static Builder|ReceivePaymentItem whereId($value)
 * @method static Builder|ReceivePaymentItem whereInvoiceId($value)
 * @method static Builder|ReceivePaymentItem whereReceivePaymentId($value)
 * @method static Builder|ReceivePaymentItem whereUpdatedAt($value)
 * @method static Builder|ReceivePaymentItem whereUserId($value)
 * @mixin \Eloquent
 */
class ReceivePaymentItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function receive_payment()
    {
        return $this->belongsTo(ReceivePayment::class, 'receive_payment_id');
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

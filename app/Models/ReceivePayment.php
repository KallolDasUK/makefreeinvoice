<?php

namespace App\Models;

use Enam\Acc\Models\Ledger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ReceivePayment
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $customer_id
 * @property string|null $invoice
 * @property string|null $payment_date
 * @property string|null $payment_sl
 * @property int|null $payment_method_id
 * @property string|null $deposit_to
 * @property string|null $note
 * @property int|null $user_id
 * @property int|null $client_id
 * @property string|null $given
 * @property-read \App\Models\Customer|null $customer
 * @property-read mixed $amount
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReceivePaymentItem[] $items
 * @property-read int|null $items_count
 * @property-read Ledger|null $ledger
 * @property-read \App\Models\PaymentMethod|null $paymentMethod
 * @method static Builder|ReceivePayment newModelQuery()
 * @method static Builder|ReceivePayment newQuery()
 * @method static Builder|ReceivePayment query()
 * @method static Builder|ReceivePayment whereClientId($value)
 * @method static Builder|ReceivePayment whereCreatedAt($value)
 * @method static Builder|ReceivePayment whereCustomerId($value)
 * @method static Builder|ReceivePayment whereDepositTo($value)
 * @method static Builder|ReceivePayment whereGiven($value)
 * @method static Builder|ReceivePayment whereId($value)
 * @method static Builder|ReceivePayment whereInvoice($value)
 * @method static Builder|ReceivePayment whereNote($value)
 * @method static Builder|ReceivePayment wherePaymentDate($value)
 * @method static Builder|ReceivePayment wherePaymentMethodId($value)
 * @method static Builder|ReceivePayment wherePaymentSl($value)
 * @method static Builder|ReceivePayment whereUpdatedAt($value)
 * @method static Builder|ReceivePayment whereUserId($value)
 * @mixin \Eloquent
 */
class ReceivePayment extends Model
{


    protected $guarded = [];


    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }


    public function paymentMethod()
    {
        return $this->belongsTo('App\Models\PaymentMethod', 'payment_method_id');
    }

    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'deposit_to');
    }

    public function items()
    {
        return $this->hasMany('App\Models\ReceivePaymentItem', 'receive_payment_id');
    }

    public function getAmountAttribute()
    {
        $invoiceAmount = ReceivePaymentItem::query()->where('receive_payment_id', $this->id)->sum('amount');
        $posAmount = PosPayment::query()->where('receive_payment_id', $this->id)->sum('amount');
        return $invoiceAmount + $posAmount;
    }

    public function getInvoiceAttribute()
    {
        return join(",", Invoice::find(ReceivePaymentItem::query()->where('receive_payment_id', $this->id)->pluck('invoice_id'))->pluck('invoice_number')->toArray());
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

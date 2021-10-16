<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BillPaymentItem
 *
 * @property int $id
 * @property int|null $bill_payment_id
 * @property int|null $bill_id
 * @property string|null $amount
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Bill|null $bill
 * @property-read \App\Models\BillPayment|null $bill_payment
 * @method static Builder|BillPaymentItem newModelQuery()
 * @method static Builder|BillPaymentItem newQuery()
 * @method static Builder|BillPaymentItem query()
 * @method static Builder|BillPaymentItem whereAmount($value)
 * @method static Builder|BillPaymentItem whereBillId($value)
 * @method static Builder|BillPaymentItem whereBillPaymentId($value)
 * @method static Builder|BillPaymentItem whereClientId($value)
 * @method static Builder|BillPaymentItem whereCreatedAt($value)
 * @method static Builder|BillPaymentItem whereId($value)
 * @method static Builder|BillPaymentItem whereUpdatedAt($value)
 * @method static Builder|BillPaymentItem whereUserId($value)
 * @mixin \Eloquent
 */
class BillPaymentItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }

    public function bill_payment()
    {
        return $this->belongsTo(BillPayment::class, 'bill_payment_id');
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

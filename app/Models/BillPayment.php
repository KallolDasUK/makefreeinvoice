<?php

namespace App\Models;

use Enam\Acc\Models\Ledger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BillPayment
 *
 * @property int $id
 * @property int|null $vendor_id
 * @property string|null $bill_id
 * @property string|null $payment_date
 * @property string|null $payment_sl
 * @property int|null $payment_method_id
 * @property string|null $ledger_id
 * @property string|null $note
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Bill|null $bill
 * @property-read mixed $amount
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BillPaymentItem[] $items
 * @property-read int|null $items_count
 * @property-read Ledger|null $ledger
 * @property-read \App\Models\PaymentMethod|null $paymentMethod
 * @property-read \App\Models\Vendor|null $vendor
 * @method static Builder|BillPayment newModelQuery()
 * @method static Builder|BillPayment newQuery()
 * @method static Builder|BillPayment query()
 * @method static Builder|BillPayment whereBillId($value)
 * @method static Builder|BillPayment whereClientId($value)
 * @method static Builder|BillPayment whereCreatedAt($value)
 * @method static Builder|BillPayment whereId($value)
 * @method static Builder|BillPayment whereLedgerId($value)
 * @method static Builder|BillPayment whereNote($value)
 * @method static Builder|BillPayment wherePaymentDate($value)
 * @method static Builder|BillPayment wherePaymentMethodId($value)
 * @method static Builder|BillPayment wherePaymentSl($value)
 * @method static Builder|BillPayment whereUpdatedAt($value)
 * @method static Builder|BillPayment whereUserId($value)
 * @method static Builder|BillPayment whereVendorId($value)
 * @mixin \Eloquent
 */
class BillPayment extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'ledger_id');
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }


    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function items()
    {
        return $this->hasMany(BillPaymentItem::class, 'bill_payment_id');
    }

    public function getAmountAttribute()
    {
        return BillPaymentItem::query()->where('bill_payment_id', $this->id)->sum('amount');
    }

    public function getBillAttribute()
    {
//        dd('test');
        return join(",", Bill::find(BillPaymentItem::query()->where('bill_payment_id', $this->id)->pluck('bill_id'))->pluck('bill_number')->toArray());
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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }


}

<?php

namespace App\Models;

use Enam\Acc\Models\Branch;
use Enam\Acc\Models\Ledger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * App\Models\PosSale
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $pos_number
 * @property string|null $date
 * @property int|null $customer_id
 * @property int|null $branch_id
 * @property int|null $ledger_id
 * @property string|null $discount_type
 * @property string|null $discount
 * @property string|null $vat
 * @property string|null $service_charge_type
 * @property string|null $service_charge
 * @property string|null $note
 * @property int|null $payment_method_id
 * @property string|null $sub_total
 * @property string|null $total
 * @property string|null $payment_amount
 * @property string|null $due
 * @property string|null $pos_status
 * @property string|null $change
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read Branch|null $branch
 * @property-read \App\Models\Customer|null $customer
 * @property-read mixed $charges
 * @property-read mixed $payment
 * @property-read Ledger|null $ledger
 * @property-read \App\Models\PaymentMethod|null $payment_method
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PosPayment[] $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PosCharge[] $pos_charges
 * @property-read int|null $pos_charges_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PosItem[] $pos_items
 * @property-read int|null $pos_items_count
 * @method static Builder|PosSale newModelQuery()
 * @method static Builder|PosSale newQuery()
 * @method static Builder|PosSale query()
 * @method static Builder|PosSale whereBranchId($value)
 * @method static Builder|PosSale whereChange($value)
 * @method static Builder|PosSale whereClientId($value)
 * @method static Builder|PosSale whereCreatedAt($value)
 * @method static Builder|PosSale whereCustomerId($value)
 * @method static Builder|PosSale whereDate($value)
 * @method static Builder|PosSale whereDiscount($value)
 * @method static Builder|PosSale whereDiscountType($value)
 * @method static Builder|PosSale whereDue($value)
 * @method static Builder|PosSale whereId($value)
 * @method static Builder|PosSale whereLedgerId($value)
 * @method static Builder|PosSale whereNote($value)
 * @method static Builder|PosSale wherePaymentAmount($value)
 * @method static Builder|PosSale wherePaymentMethodId($value)
 * @method static Builder|PosSale wherePosNumber($value)
 * @method static Builder|PosSale wherePosStatus($value)
 * @method static Builder|PosSale whereServiceCharge($value)
 * @method static Builder|PosSale whereServiceChargeType($value)
 * @method static Builder|PosSale whereSubTotal($value)
 * @method static Builder|PosSale whereTotal($value)
 * @method static Builder|PosSale whereUpdatedAt($value)
 * @method static Builder|PosSale whereUserId($value)
 * @method static Builder|PosSale whereVat($value)
 * @mixin \Eloquent
 */
class PosSale extends Model
{


    protected $guarded = [];
    protected $appends = ['due', 'payment', 'charges'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function pos_items()
    {
        return $this->hasMany(PosItem::class, 'pos_sales_id');
    }

    public function pos_charges()
    {
        return $this->hasMany(PosCharge::class, 'pos_sales_id');
    }

    public function payments()
    {
        return $this->hasMany(PosPayment::class, 'pos_sales_id');
    }


    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'ledger_id');
    }

    public static function nextOrderNumber($increment = 1)
    {
        $next_order = 'POS-' . str_pad(count(self::query()->get()) + $increment, 4, '0', STR_PAD_LEFT);
        if (self::query()->where('pos_number', $next_order)->exists()) {
            return self::nextOrderNumber($increment + 1);
        }
        return $next_order;
    }

    public function getDueAttribute()
    {
        $due = 0;
        $payment = $this->payments->sum('amount');
        $due = $this->total - $payment;

        return number_format((float)$due, 2, '.', '');

    }


    public function getChargesAttribute()
    {
        return $this->pos_charges()->where('key','not like','%discount%')->sum('amount');
    }
    public function getDiscountAttribute()
    {
        return $this->pos_charges()->where('key','like','%discount%')->sum('amount');
    }

    public function getTaxAttribute()
    {

        $tax = 0;
        foreach ($this->pos_charges as $item) {
//            dump($item->key);
            if (Str::contains(strtolower($item->key), 'vat') || Str::contains(strtolower($item->key), 'tax')) {
                $tax += $item->amount;
            }
        }
        return $tax;
    }


    public function getPaymentAttribute()
    {
        $paymentAmount = $this->payments->sum('amount');
        return $paymentAmount;
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

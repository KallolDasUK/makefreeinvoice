<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bill
 *
 * @property int $id
 * @property int|null $vendor_id
 * @property string|null $bill_number
 * @property string|null $order_number
 * @property string|null $bill_date
 * @property string|null $due_date
 * @property string|null $sub_total
 * @property string|null $total
 * @property string|null $discount_type
 * @property string|null $discount_value
 * @property string|null $discount
 * @property string|null $shipping_charge
 * @property string|null $notes
 * @property string|null $bill_status
 * @property string|null $attachment
 * @property string|null $secret
 * @property int|null $user_id
 * @property int|null $client_id
 * @property string $currency
 * @property int|null $bill_payment_id
 * @property int|null $is_payment
 * @property string|null $payment_amount
 * @property int|null $payment_method_id
 * @property int|null $deposit_to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $payment_status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BillExtraField[] $bill_extra
 * @property-read int|null $bill_extra_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BillItem[] $bill_items
 * @property-read int|null $bill_items_count
 * @property-read mixed $age
 * @property-read mixed $charges
 * @property-read mixed $due
 * @property-read mixed $extra_fields
 * @property-read mixed $paid
 * @property-read mixed $payment
 * @property-read mixed $payment_status_text
 * @property-read mixed $taxable_amount
 * @property-read mixed $taxes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BillPaymentItem[] $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\Vendor|null $vendor
 * @method static Builder|Bill newModelQuery()
 * @method static Builder|Bill newQuery()
 * @method static Builder|Bill query()
 * @method static Builder|Bill whereAttachment($value)
 * @method static Builder|Bill whereBillDate($value)
 * @method static Builder|Bill whereBillNumber($value)
 * @method static Builder|Bill whereBillPaymentId($value)
 * @method static Builder|Bill whereBillStatus($value)
 * @method static Builder|Bill whereClientId($value)
 * @method static Builder|Bill whereCreatedAt($value)
 * @method static Builder|Bill whereCurrency($value)
 * @method static Builder|Bill whereDepositTo($value)
 * @method static Builder|Bill whereDiscount($value)
 * @method static Builder|Bill whereDiscountType($value)
 * @method static Builder|Bill whereDiscountValue($value)
 * @method static Builder|Bill whereDueDate($value)
 * @method static Builder|Bill whereId($value)
 * @method static Builder|Bill whereIsPayment($value)
 * @method static Builder|Bill whereNotes($value)
 * @method static Builder|Bill whereOrderNumber($value)
 * @method static Builder|Bill wherePaymentAmount($value)
 * @method static Builder|Bill wherePaymentMethodId($value)
 * @method static Builder|Bill wherePaymentStatus($value)
 * @method static Builder|Bill whereSecret($value)
 * @method static Builder|Bill whereShippingCharge($value)
 * @method static Builder|Bill whereSubTotal($value)
 * @method static Builder|Bill whereTotal($value)
 * @method static Builder|Bill whereUpdatedAt($value)
 * @method static Builder|Bill whereUserId($value)
 * @method static Builder|Bill whereVendorId($value)
 * @mixin \Eloquent
 */
class Bill extends Model
{

    const Partial = "Partial";
    const Paid = "Paid";
    const UnPaid = "Unpaid";

    protected $appends = ['paid', 'due'];

    protected $guarded = [];

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    public function bill_items()
    {
        return $this->hasMany('App\Models\BillItem', 'bill_id');
    }

    public function bill_extra()
    {
        return $this->hasMany('App\Models\BillExtraField', 'bill_id');
    }

    public function getExtraFieldsAttribute()
    {
        return ExtraField::query()->where('type', Bill::class)->where('type_id', $this->id)->get();
    }


    public function getDueAttribute()
    {
        $due = 0;
        try {
            $payment = $this->payment;
        } catch (\Exception $exception) {
            $payment = 0;
        }
//        dd(optional($this->payments));
        $due = $this->total - $payment;

        return number_format((float)$due, 2, '.', '');

    }


    public function getPaidAttribute()
    {
        return $this->payment;
    }

    public function getPaymentAttribute()
    {
        return optional($this->payments)->sum('amount') + ($this->from_advance ?? 0);
    }

    public function payments()
    {
        return $this->hasMany(BillPaymentItem::class, 'bill_id');
    }


    public function getPaymentStatusTextAttribute()
    {
        $paymentAmount = $this->payment;
        $this->total = floatval($this->total);
//        dump($paymentAmount,$this->total);
        if ($this->total <= $paymentAmount) {
            return self::Paid;
        } else if ($paymentAmount > 0 && $paymentAmount < $this->total) {
            return self::Partial;
        } else {
            return self::UnPaid;
        }
    }

    public function getTaxableAmountAttribute()
    {
        $taxable = 0;
        foreach ($this->taxes as $tax) {
            $taxable += $tax['tax_amount'];
        }
        return $taxable;
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

    public function getTaxesAttribute()
    {

        $taxes = [];
        $tax_id = [];
//        dd('test');
        foreach ($this->bill_items as $bill_item) {
            $bill_item->tax = 0;
            if ($bill_item->tax_id) {
                $tax = Tax::find($bill_item->tax_id);
//                dd($tax,$bill_item->tax_id);
                if ($tax) {
                    $taxAmount = (floatval($tax->value) / 100) * $bill_item->amount;
                    if (in_array($tax->id, $tax_id)) {
                        $taxes[$tax->id]['tax_amount'] += $taxAmount;
                        continue;
                    }
                    $taxes[$tax->id] = ['tax_id' => $tax->id, 'tax_name' => $tax->name . '(' . $tax->value . '%)', 'tax_amount' => $taxAmount];
                    $tax_id[] = $tax->id;

                }
            }

        }
//        dd($taxes, $tax_id);
        return $taxes;
    }

    public static function nextInvoiceNumber($increment = 1)
    {
        $next_invoice = 'BILL-' . str_pad(count(self::query()->get()) + $increment, 4, '0', STR_PAD_LEFT);
        if (self::query()->where('bill_number', $next_invoice)->exists()) {
            return self::nextInvoiceNumber($increment + 1);
        }
        return $next_invoice;
    }

    public function getAgeAttribute()
    {
        $age = 0;
        if ($this->bill_date <= today()->toDateString()) {
            $age = Carbon::today()->diffInDays($this->bill_date);
        }
        return $age;
    }

    public function getChargesAttribute()
    {
        return $this->bill_extra()->sum('value');
    }

    public function getDiscountAttribute()
    {
        $discount = 0;
        if ($this->discount_type == 'Flat') {
            $discount = $this->discount_value;
        } else {
            $discount = ($this->discount_value * $this->sub_total) / 100;
        }
        return $discount;
    }

}

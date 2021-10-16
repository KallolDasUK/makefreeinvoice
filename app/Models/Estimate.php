<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Estimate
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $customer_id
 * @property string|null $estimate_number
 * @property string|null $order_number
 * @property string|null $estimate_date
 * @property string|null $payment_terms
 * @property string|null $due_date
 * @property string|null $sub_total
 * @property string|null $total
 * @property string|null $discount_type
 * @property string|null $discount_value
 * @property string|null $discount
 * @property string|null $shipping_charge
 * @property string|null $terms_condition
 * @property string|null $notes
 * @property string|null $attachment
 * @property string $currency
 * @property string|null $shipping_date
 * @property string|null $secret
 * @property int|null $user_id
 * @property int|null $client_id
 * @property string|null $estimate_status
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EstimateExtraField[] $estimate_extra
 * @property-read int|null $estimate_extra_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EstimateItem[] $estimate_items
 * @property-read int|null $estimate_items_count
 * @property-read mixed $extra_fields
 * @property-read mixed $taxable_amount
 * @property-read mixed $taxes
 * @method static Builder|Estimate newModelQuery()
 * @method static Builder|Estimate newQuery()
 * @method static Builder|Estimate query()
 * @method static Builder|Estimate whereAttachment($value)
 * @method static Builder|Estimate whereClientId($value)
 * @method static Builder|Estimate whereCreatedAt($value)
 * @method static Builder|Estimate whereCurrency($value)
 * @method static Builder|Estimate whereCustomerId($value)
 * @method static Builder|Estimate whereDiscount($value)
 * @method static Builder|Estimate whereDiscountType($value)
 * @method static Builder|Estimate whereDiscountValue($value)
 * @method static Builder|Estimate whereDueDate($value)
 * @method static Builder|Estimate whereEstimateDate($value)
 * @method static Builder|Estimate whereEstimateNumber($value)
 * @method static Builder|Estimate whereEstimateStatus($value)
 * @method static Builder|Estimate whereId($value)
 * @method static Builder|Estimate whereNotes($value)
 * @method static Builder|Estimate whereOrderNumber($value)
 * @method static Builder|Estimate wherePaymentTerms($value)
 * @method static Builder|Estimate whereSecret($value)
 * @method static Builder|Estimate whereShippingCharge($value)
 * @method static Builder|Estimate whereShippingDate($value)
 * @method static Builder|Estimate whereSubTotal($value)
 * @method static Builder|Estimate whereTermsCondition($value)
 * @method static Builder|Estimate whereTotal($value)
 * @method static Builder|Estimate whereUpdatedAt($value)
 * @method static Builder|Estimate whereUserId($value)
 * @mixin \Eloquent
 */
class Estimate extends Model
{


    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function estimate_items()
    {
        return $this->hasMany('App\Models\EstimateItem', 'estimate_id');
    }

    public function estimate_extra()
    {
        return $this->hasMany('App\Models\EstimateExtraField', 'estimate_id');
    }

    public function getExtraFieldsAttribute()
    {
        return ExtraField::query()->where('type', Estimate::class)->where('type_id', $this->id)->get();
    }

    public function getTaxesAttribute()
    {
        $taxes = [];
        $tax_id = [];
        foreach ($this->estimate_items as $invoice_item) {
            $invoice_item->tax = 0;
            if ($invoice_item->tax_id) {
                $tax = Tax::find($invoice_item->tax_id);
                if ($tax) {
                    $taxAmount = (floatval($tax->value) / 100) * $invoice_item->amount;
                    if (in_array($tax->id, $tax_id)) {
                        $taxes[$tax->id]['tax_amount'] += $taxAmount;
                        continue;
                    }
                    $taxes[$tax->id] = ['tax_id' => $tax->id, 'tax_name' => $tax->name . '(' . $tax->value . '%)', 'tax_amount' => $taxAmount];
                    $tax_id[] = $tax->id;

                }
            }

        }
        return $taxes;
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


}

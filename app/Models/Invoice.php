<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Invoice
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $customer_id
 * @property string|null $invoice_number
 * @property string|null $order_number
 * @property string|null $invoice_date
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
 * @property int $is_payment
 * @property string|null $payment_amount
 * @property int|null $payment_method_id
 * @property int|null $deposit_to
 * @property int|null $receive_payment_id
 * @property string $invoice_status
 * @property string|null $secret
 * @property int|null $user_id
 * @property int|null $client_id
 * @property string $payment_status
 * @property int|null $sr_id
 * @property-read \App\Models\Customer|null $customer
 * @property-read mixed $age
 * @property-read mixed $charges
 * @property-read mixed $due
 * @property-read mixed $extra_fields
 * @property-read mixed $payment
 * @property-read mixed $payment_status_text
 * @property-read mixed $taxable_amount
 * @property-read mixed $taxes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoiceExtraField[] $invoice_extra
 * @property-read int|null $invoice_extra_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoiceItem[] $invoice_items
 * @property-read int|null $invoice_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReceivePaymentItem[] $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\SR|null $sr
 * @method static Builder|Invoice newModelQuery()
 * @method static Builder|Invoice newQuery()
 * @method static Builder|Invoice query()
 * @method static Builder|Invoice whereAttachment($value)
 * @method static Builder|Invoice whereClientId($value)
 * @method static Builder|Invoice whereCreatedAt($value)
 * @method static Builder|Invoice whereCurrency($value)
 * @method static Builder|Invoice whereCustomerId($value)
 * @method static Builder|Invoice whereDepositTo($value)
 * @method static Builder|Invoice whereDiscount($value)
 * @method static Builder|Invoice whereDiscountType($value)
 * @method static Builder|Invoice whereDiscountValue($value)
 * @method static Builder|Invoice whereDueDate($value)
 * @method static Builder|Invoice whereId($value)
 * @method static Builder|Invoice whereInvoiceDate($value)
 * @method static Builder|Invoice whereInvoiceNumber($value)
 * @method static Builder|Invoice whereInvoiceStatus($value)
 * @method static Builder|Invoice whereIsPayment($value)
 * @method static Builder|Invoice whereNotes($value)
 * @method static Builder|Invoice whereOrderNumber($value)
 * @method static Builder|Invoice wherePaymentAmount($value)
 * @method static Builder|Invoice wherePaymentMethodId($value)
 * @method static Builder|Invoice wherePaymentStatus($value)
 * @method static Builder|Invoice wherePaymentTerms($value)
 * @method static Builder|Invoice whereReceivePaymentId($value)
 * @method static Builder|Invoice whereSecret($value)
 * @method static Builder|Invoice whereShippingCharge($value)
 * @method static Builder|Invoice whereShippingDate($value)
 * @method static Builder|Invoice whereSrId($value)
 * @method static Builder|Invoice whereSubTotal($value)
 * @method static Builder|Invoice whereTermsCondition($value)
 * @method static Builder|Invoice whereTotal($value)
 * @method static Builder|Invoice whereUpdatedAt($value)
 * @method static Builder|Invoice whereUserId($value)
 * @mixin \Eloquent
 */
class Invoice extends Model
{

    const Partial = "Partial";
    const Paid = "Paid";
    const UnPaid = "Unpaid";

    protected $guarded = [];
    protected $appends = ['due', 'sales_return_amount'];


    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(auth()->user()->timezone);
    }

    public function customer()
    {

        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function sr()
    {

        return $this->belongsTo(SR::class, 'sr_id');
    }

    public function invoice_items()
    {
        return $this->hasMany('App\Models\InvoiceItem', 'invoice_id');
    }

    public function invoice_extra()
    {
        return $this->hasMany('App\Models\InvoiceExtraField', 'invoice_id');
    }

    public function getExtraFieldsAttribute()
    {
        return self::getExtraFields($this->id);
    }

    private static $ef;

    public static function getExtraFields($id)
    {
        if (!isset(self::$ef)) {
            self::$ef = ExtraField::query()->where('type', Invoice::class)->where('type_id', $id)->get();
        }

        return self::$ef;
    }

    public function getSalesReturnAmountAttribute()
    {

        $sales_return = $this->sales_return->sum('total');
        return $sales_return == 0 ? '' : $sales_return;
    }


    public function payments()
    {
        return $this->hasMany(ReceivePaymentItem::class, 'invoice_id');
    }

    public function sales_return()
    {
        return $this->hasMany(SalesReturn::class, 'invoice_number', 'invoice_number');
    }

    public function getDueAttribute()
    {
        $due = 0;
        $payment = $this->payment;
        $sales_return = $this->sales_return->sum('total');
        $due = $this->total - $payment - $sales_return;

        return number_format((float)$due, 2, '.', '');

    }

    public function getPaymentAttribute()
    {
        $paymentAmount = $this->payments->sum('amount') + $this->from_advance;
        return $paymentAmount;
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
        foreach ($this->invoice_items as $invoice_item) {
            $invoice_item->tax = 0;
            if ($invoice_item->tax_id) {
                $tax = Tax::find($invoice_item->tax_id);
//                dd($tax,$invoice_item->tax_id);
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
//        dd($taxes, $tax_id);
        return $taxes;
    }

    public static function nextInvoiceNumber($increment = 1)
    {
        $next_invoice = 'INV-' . str_pad(count(self::query()->get()) + $increment, 4, '0', STR_PAD_LEFT);
        if (self::query()->where('invoice_number', $next_invoice)->exists()) {
            return self::nextInvoiceNumber($increment + 1);
        }
        return $next_invoice;
    }

    public function getAgeAttribute()
    {
        $age = 0;
        if ($this->invoice_date <= today()->toDateString()) {
            $age = Carbon::today()->diffInDays($this->invoice_date);
        }
        return $age;
    }

    public function getChargesAttribute()
    {
        return $this->invoice_extra()->sum('value');
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


    public static function summary($start_date, $end_date)
    {
        $overdue = 0;
        $draft = 0;
        $paid = 0;
        $due = 0;
        $total = 0;

        Invoice::query()
            ->with(['payments', 'sales_return'])
            ->when($start_date != null, function ($query) use ($start_date, $end_date) {
                return $query->whereBetween('invoice_date', [$start_date, $end_date]);
            })
            ->get()
            ->map(function ($invoice) use (&$overdue, &$draft, &$paid, &$due, &$total) {
                if ($invoice->due_date <= today()->toDateString() && $invoice->due > 0) {
                    $overdue += $invoice->due;
                }
                if ($invoice->invoice_status == 'draft' && $invoice->due > 0) {
                    $draft += $invoice->due;
                }
                $paid += $invoice->payment;
                $due += $invoice->due;
                $total += $invoice->total;


            });

        return (object)[
            'overdue' => $overdue,
            'draft' => $draft,
            'paid' => $paid,
            'due' => $due,
            'total' => $total,
        ];
    }

    public static function overdue($start_date, $end_date)
    {
        $overdue = 0;
        Invoice::query()
            ->with(['payments'])
            ->when($start_date != null, function ($query) use ($start_date, $end_date) {
                return $query->whereBetween('invoice_date', [$start_date, $end_date]);
            })
            ->where('due_date', '<=', today()->toDateString())
            ->get()->map(function ($invoice) use (&$overdue) {
//            dump($invoice);
                if ($invoice->due > 0) {

                    $overdue += $invoice->due;
                }
            });
        return $overdue;
    }

    public static function draft($start_date, $end_date)
    {
        $draft = 0;
        Invoice::query()
            ->with(['payments'])
            ->when($start_date != null, function ($query) use ($start_date, $end_date) {
                return $query->whereBetween('invoice_date', [$start_date, $end_date]);
            })->where('invoice_status', 'draft')
            ->get()
            ->map(function ($invoice) use (&$draft) {
                if ($invoice->due > 0) $draft += $invoice->due;
            });
        return $draft;
    }


    public static function paid($start_date, $end_date)
    {
        $amount = 0;
        Invoice::query()
            ->with(['payments'])
            ->when($start_date != null, function ($query) use ($start_date, $end_date) {
                return $query->whereBetween('invoice_date', [$start_date, $end_date]);
            })->get()->map(function ($invoice) use (&$amount) {
                $amount += $invoice->payment;
            });
        return $amount;
    }

    public static function due($start_date, $end_date)
    {
        $amount = 0;
        Invoice::query()
            ->with(['payments'])
            ->when($start_date != null, function ($query) use ($start_date, $end_date) {
                return $query->whereBetween('invoice_date', [$start_date, $end_date]);
            })->get()->map(function ($invoice) use (&$amount) {
                $amount += $invoice->due;
            });
        return $amount;
    }

    public static function total($start_date, $end_date)
    {
        $amount = 0;
        Invoice::query()
            ->with(['payments'])
            ->when($start_date != null, function ($query) use ($start_date, $end_date) {
                return $query->whereBetween('invoice_date', [$start_date, $end_date]);
            })->get()->map(function ($invoice) use (&$amount) {
                $amount += $invoice->total;
            });
        return $amount;
    }


}

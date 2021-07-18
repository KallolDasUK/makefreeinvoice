<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceivePayment extends Model
{
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'receive_payments';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'customer_id',
                  'payment_date',
                  'payment_sl',
                  'payment_method_id',
                  'deposit_to',
                  'note'
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
    
    /**
     * Get the customer for this model.
     *
     * @return App\Models\Customer
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer','customer_id');
    }

    /**
     * Get the paymentMethod for this model.
     *
     * @return App\Models\PaymentMethod
     */
    public function paymentMethod()
    {
        return $this->belongsTo('App\Models\PaymentMethod','payment_method_id');
    }

    /**
     * Set the payment_date.
     *
     * @param  string  $value
     * @return void
     */
    public function setPaymentDateAttribute($value)
    {
        $this->attributes['payment_date'] = !empty($value) ? \DateTime::createFromFormat('[% date_format %]', $value) : null;
    }

    /**
     * Get payment_date in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getPaymentDateAttribute($value)
    {
        return \DateTime::createFromFormat($this->getDateFormat(), $value)->format('j/n/Y');
    }

}

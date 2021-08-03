<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vendors';

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
                  'name',
                  'photo',
                  'company_name',
                  'phone',
                  'email',
                  'country',
                  'street_1',
                  'street_2',
                  'city',
                  'state',
                  'zip_post',
                  'address',
                  'website'
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
    



}

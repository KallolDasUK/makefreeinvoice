<?php

namespace Enam\Acc\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transactions';
    protected $guarded = [];


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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Get the branch for this model.
     *
     * @return Enam\Acc\Models\Branch
     */
    public function branch()
    {
        return $this->belongsTo('Enam\Acc\Models\Branch', 'branch_id');
    }

    public function transaction_details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');

    }

    /**
     * Set the date.
     *
     * @param string $value
     * @return void
     */


}

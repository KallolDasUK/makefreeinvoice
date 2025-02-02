<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectPayment extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }


    public function referred()
    {
        return $this->belongsTo('App\Models\User', 'referred_by');
    }


}

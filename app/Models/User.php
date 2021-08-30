<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getNextUserID()
    {

        $statement = DB::select("show table status like 'users'");

        return $statement[0]->Auto_increment;
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'user_id')->withoutGlobalScope('scopeClient');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class, 'user_id')->withoutGlobalScope('scopeClient');
    }

    public function estimates()
    {
        return $this->hasMany(Estimate::class, 'user_id')->withoutGlobalScope('scopeClient');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'user_id')->withoutGlobalScope('scopeClient');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'user_id')->withoutGlobalScope('scopeClient');
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class, 'user_id')->withoutGlobalScope('scopeClient');
    }

    public function getPlanAttribute()
    {
        $settings = json_decode(MetaSetting::query()->withoutGlobalScope('scopeClient')->where('client_id', $this->client_id)->pluck('value', 'key')->toJson());
        $plan = $settings->plan_name ?? null;
        if ($plan != null) {
            if (Str::contains(strtolower($plan), 'basic')) $plan = 'basic';
            elseif (Str::contains(strtolower($plan), 'premium')) $plan = 'premium';
        } else $plan = 'free';
//        dump($plan);
        return $plan;
    }

    public function getSettingsAttribute()
    {
        return json_decode(MetaSetting::query()->withoutGlobalScope('scopeClient')->where('client_id', $this->client_id)->pluck('value', 'key')->toJson());
    }
}

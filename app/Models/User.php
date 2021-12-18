<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property int|null $client_id
 * @property string|null $role
 * @property string|null $last_active_at
 * @property string|null $affiliate_tag
 * @property string|null $referred_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bill[] $bills
 * @property-read int|null $bills_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer[] $customers
 * @property-read int|null $customers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Estimate[] $estimates
 * @property-read int|null $estimates_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Expense[] $expenses
 * @property-read int|null $expenses_count
 * @property-read mixed $invoice_count
 * @property-read mixed $login_url
 * @property-read mixed $plan
 * @property-read mixed $settings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PosSale[] $pos_sales
 * @property-read int|null $pos_sales_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $referred
 * @property-read int|null $referred_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Cashier\Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vendor[] $vendors
 * @property-read int|null $vendors_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAffiliateTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastActiveAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereReferredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable, HasRoles;

    protected $appends = ['invoice_count'];
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

//    protected $guard_name = 'web';


    public static function getNextUserID()
    {

        $statement = DB::select("show table status like 'users'");

        return $statement[0]->Auto_increment;
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'user_id')->withoutGlobalScope('scopeClient');
    }

    public function pos_sales()
    {
        return $this->hasMany(PosSale::class, 'user_id')->withoutGlobalScope('scopeClient');
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

    public function user_unseen_notifications()
    {
        return $this->hasMany(UserNotification::class, 'user_id')->where('seen', false);
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class, 'user_id')->withoutGlobalScope('scopeClient');
    }

    public function getAddressAttribute()
    {
        $address = '';

        if ($this->settings->street_1 ?? false) {
            $address .= $this->settings->street_1;
        }
        if ($this->settings->street_2 ?? false) {
            $address .= ',' . $this->settings->street_2;
        }
        if ($this->settings->state ?? false) {
            $address .= ',' . $this->settings->state;
        }
        if ($this->settings->zip_post ?? false) {
            $address .= ',' . $this->settings->zip_post;
        }
        return $address;

    }

    public function user_role()
    {
        return $this->belongsTo(UserRole::class, 'role_id');
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


    public function getLoginUrlAttribute()
    {

        return Url::temporarySignedRoute('master.users.login', Carbon::now()->addMinutes(2), ['email' => $this->email]);
    }

    public function getInvoiceCountAttribute()
    {
        return count($this->invoices);
    }

    public function referred()
    {
        return $this->hasMany(self::class, 'referred_by', 'affiliate_tag');
    }


    public function getRolesPermissionAttribute()
    {
        $permission = json_decode(optional($this->user_role)->payload ?? '{}', true);
        $p = [];
        foreach ($permission as $key => $items) {
            foreach ($items as $crudType => $hasPermission) {
                if ($hasPermission) {
                    $p[] = "$crudType $key";
                }
            }
        }
        return $p;
    }

    public function getIsAdminAttribute()
    {
        return $this->role_id == null;

    }
}

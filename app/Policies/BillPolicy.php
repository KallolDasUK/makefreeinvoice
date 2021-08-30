<?php

namespace App\Policies;

use App\Models\Bill;
use App\Models\GlobalSetting;
use App\Models\MetaSetting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;

class BillPolicy
{
    use HandlesAuthorization;

    public $settings = null;
    public $global_settings = null;
    public $plan = null;

    public function __construct()
    {
        $this->settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());
        $this->global_settings = json_decode(GlobalSetting::query()->pluck('value', 'key')->toJson(), true);
        $this->plan = $this->settings->plan_name ?? null;
        if ($this->plan != null) {
            if (Str::contains($this->plan, 'basic')) $this->plan = 'basic';
            elseif (Str::contains($this->plan, 'premium')) $this->plan = 'premium';
        } else$this->plan = 'free';

    }


    public function viewAny(User $user)
    {
        $has_access = $this->global_settings[$this->plan . '_bills_viewAny'];
        return boolval($has_access);
    }


    public function view(User $user, Bill $bill)
    {
        $has_access = $this->global_settings[$this->plan . '_bills_view'];
        return boolval($has_access);
    }


    public function create(User $user)
    {
        $has_access = $this->global_settings[$this->plan . '_bills_create'];
        return boolval($has_access);
    }


    public function update(User $user, Bill $bill)
    {
        $has_access = $this->global_settings[$this->plan . '_bills_update'];
        return boolval($has_access);
    }


    public function delete(User $user, Bill $bill)
    {
        $has_access = $this->global_settings[$this->plan . '_bills_delete'];
        return boolval($has_access);
    }

}

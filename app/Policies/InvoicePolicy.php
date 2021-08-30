<?php

namespace App\Policies;

use App\Models\GlobalSetting;
use App\Models\Invoice;
use App\Models\MetaSetting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;

class InvoicePolicy
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

    private function has_access($ability)
    {
        try {
            $has_access = $this->global_settings[$this->plan . '_invoices_' . $ability];
        } catch (\Exception $exception) {
            $has_access = false;
        }
        return boolval($has_access);
    }

    public function viewAny(User $user)
    {
        return $this->has_access(__FUNCTION__);
    }


    public function view(User $user, Invoice $invoice)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function create(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function update(User $user, Invoice $invoice)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function delete(User $user, Invoice $invoice)
    {
        return $this->has_access(__FUNCTION__);
    }


}

<?php

namespace App\Policies;

use App\Models\GlobalSetting;
use App\Models\MetaSetting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;

class ReportPolicy
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
            $has_access = $this->global_settings[$this->plan . '_reports_' . $ability];
        } catch (\Exception $exception) {
            $has_access = false;
        }
        return boolval($has_access);
    }

    public function tax_summary()
    {
        return $this->has_access(__FUNCTION__);
    }

    public function ar_aging()
    {
        return $this->has_access(__FUNCTION__);
    }

    public function ap_aging()
    {
        return $this->has_access(__FUNCTION__);

    }

    public function stock_report()
    {
        return $this->has_access(__FUNCTION__);

    }

    public function trial_balance()
    {
        return $this->has_access(__FUNCTION__);
    }

    public function receipt_payment()
    {
        return $this->has_access(__FUNCTION__);

    }

    public function ledger()
    {
        return $this->has_access(__FUNCTION__);
    }

    public function profit_loss()
    {
        return $this->has_access(__FUNCTION__);
    }

    public function voucher()
    {
        return $this->has_access(__FUNCTION__);
    }

    public function cash_book()
    {
        return $this->has_access(__FUNCTION__);
    }

    public function day_book()
    {
        return $this->has_access(__FUNCTION__);
    }

    public function balance_sheet()
    {
        return $this->has_access(__FUNCTION__);
    }


}

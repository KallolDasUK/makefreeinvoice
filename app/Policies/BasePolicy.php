<?php

namespace App\Policies;

use App\Models\GlobalSetting;
use App\Models\MetaSetting;
use App\Models\User;
use Enam\Acc\Models\Ledger;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;

class BasePolicy
{
    use HandlesAuthorization;

    private static $settings;

    private static $instance_global_settings;

    public $global_settings = null;

    public $plan = null;



    public static function getSettings()
    {
        if (!isset(self::$settings)) {
            self::$settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());
        }

        return self::$settings;
    }

    public static function getGlobalSettings()
    {
        if (!isset(self::$instance_global_settings)) {
            self::$instance_global_settings = json_decode(GlobalSetting::query()->pluck('value', 'key')->toJson(), true);
        }

        return self::$instance_global_settings;
    }

    public function __construct()
    {
        $this->global_settings = self::getGlobalSettings();
        $this->plan = self::getSettings()->plan_name ?? null;
        if ($this->plan != null) {
            if (Str::contains(strtolower($this->plan), 'basic')) $this->plan = 'basic';
            elseif (Str::contains(strtolower($this->plan), 'premium')) $this->plan = 'premium';
            elseif (Str::contains(strtolower($this->plan), 'trial')) $this->plan = 'premium';
            elseif (Str::contains(strtolower($this->plan), 'free')) $this->plan = 'free';
            else $this->plan = 'trial';
        } else {
            $this->plan = 'trial';

        }

    }

}

<?php

namespace App\Policies;

use App\Models\GlobalSetting;
use App\Models\MetaSetting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;

class BasePolicy
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
            if (Str::contains(strtolower($this->plan), 'basic')) $this->plan = 'basic';
            elseif (Str::contains(strtolower($this->plan), 'premium')) $this->plan = 'premium';
            elseif (Str::contains(strtolower($this->plan), 'trial')) $this->plan = 'premium';
            else $this->plan = 'free';
        } else $this->plan = 'free';

    }

}

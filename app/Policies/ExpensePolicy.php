<?php

namespace App\Policies;

use App\Models\Expense;
use App\Models\GlobalSetting;
use App\Models\MetaSetting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;

class ExpensePolicy extends BasePolicy
{
    use HandlesAuthorization;


    private function has_access($ability)
    {
        try {
            $has_access = $this->global_settings[$this->plan . '_expenses_' . $ability];
        } catch (\Exception $exception) {
            $has_access = false;
        }
        return boolval($has_access);
    }

    public function viewAny(User $user)
    {
        return $this->has_access(__FUNCTION__);
    }


    public function view(User $user, Expense $invoice)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function create(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function update(User $user, Expense $expense)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function delete(User $user, Expense $expense)
    {
        return $this->has_access(__FUNCTION__);
    }
}

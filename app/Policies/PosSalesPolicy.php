<?php

namespace App\Policies;

use App\Models\PosSale;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PosSalesPolicy extends BasePolicy
{
    use HandlesAuthorization;

    private function has_access($ability)
    {
        try {
            $has_access = $this->global_settings[$this->plan . '_pos_sales_' . $ability];
        } catch (\Exception $exception) {
            $has_access = false;
        }
        return boolval($has_access);
    }

    public function viewAny(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function view(User $user, PosSale $posSale)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function create(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function update(User $user, PosSale $posSale)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function delete(User $user, PosSale $posSale)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function restore(User $user, PosSale $posSale)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function forceDelete(User $user, PosSale $posSale)
    {
        return $this->has_access(__FUNCTION__);

    }
}

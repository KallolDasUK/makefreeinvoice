<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Auth\Access\HandlesAuthorization;

class VendorPolicy extends BasePolicy
{
    use HandlesAuthorization;

    private function has_access($ability)
    {
        try {
            $has_access = $this->global_settings[$this->plan . '_vendors_' . $ability];
        } catch (\Exception $exception) {
            $has_access = false;
        }
        return boolval($has_access);
    }


    public function viewAny(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }  public function bill_payment(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function view(User $user, Vendor $vendor)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function create(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function update(User $user, Vendor $vendor)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function delete(User $user, Vendor $vendor)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function restore(User $user, Vendor $vendor)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function forceDelete(User $user, Vendor $vendor)
    {
        return $this->has_access(__FUNCTION__);

    }
}

<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Faker\Provider\Base;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy extends BasePolicy
{
    use HandlesAuthorization;

    private function has_access($ability)
    {
        try {
            $has_access = $this->global_settings[$this->plan . '_customers_' . $ability];
        } catch (\Exception $exception) {
            $has_access = false;
        }
        return boolval($has_access);
    }


    public function viewAny(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }

    public function receive_payment(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function view(User $user, Customer $customer)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function create(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function update(User $user, Customer $customer)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function delete(User $user, Customer $customer)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function restore(User $user, Customer $customer)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function forceDelete(User $user, Customer $customer)
    {
        return $this->has_access(__FUNCTION__);

    }
}

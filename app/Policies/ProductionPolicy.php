<?php

namespace App\Policies;

use App\Models\Production;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductionPolicy extends BasePolicy
{
    use HandlesAuthorization;

    private function has_access($ability)
    {
        try {
            $has_access = $this->global_settings[$this->plan . '_productions_' . $ability];
        } catch (\Exception $exception) {
            $has_access = false;
        }
        return boolval($has_access);
    }

    public function viewAny(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function view(User $user, Production $production)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function create(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function update(User $user, Production $production)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function delete(User $user, Production $production)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function restore(User $user, Production $production)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function forceDelete(User $user, Production $production)
    {
        return $this->has_access(__FUNCTION__);

    }
}

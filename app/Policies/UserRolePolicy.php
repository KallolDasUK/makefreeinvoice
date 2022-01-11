<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserRolePolicy extends BasePolicy
{
    use HandlesAuthorization;

    private function has_access($ability)
    {
        try {
            $has_access = $this->global_settings[$this->plan . '_users_' . $ability];
        } catch (\Exception $exception) {
            $has_access = false;
        }
        return boolval($has_access);
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\UserRole $userRole
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, UserRole $userRole)
    {
        return $this->has_access(__FUNCTION__);

    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\UserRole $userRole
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, UserRole $userRole)
    {
        return $this->has_access(__FUNCTION__);

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\UserRole $userRole
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, UserRole $userRole)
    {
        return $this->has_access(__FUNCTION__);

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\UserRole $userRole
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, UserRole $userRole)
    {
        return $this->has_access(__FUNCTION__);

    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\UserRole $userRole
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, UserRole $userRole)
    {
        return $this->has_access(__FUNCTION__);

    }
}

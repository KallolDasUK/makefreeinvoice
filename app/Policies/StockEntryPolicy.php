<?php

namespace App\Policies;

use App\Models\StockEntry;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StockEntryPolicy extends BasePolicy
{

    private function has_access($ability)
    {
        try {
            $has_access = $this->global_settings[$this->plan . '_stock_entries_' . $ability];
        } catch (\Exception $exception) {
            $has_access = false;
        }
        return boolval($has_access);
    }

    use HandlesAuthorization;


    public function viewAny(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function view(User $user, StockEntry $stockEntry)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function create(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function update(User $user, StockEntry $stockEntry)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function delete(User $user, StockEntry $stockEntry)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function restore(User $user, StockEntry $stockEntry)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function forceDelete(User $user, StockEntry $stockEntry)
    {
        return $this->has_access(__FUNCTION__);

    }
}

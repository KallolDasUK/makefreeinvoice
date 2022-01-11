<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy extends BasePolicy
{
    use HandlesAuthorization;

    private function has_access($ability)
    {
        try {
            $has_access = $this->global_settings[$this->plan . '_products_' . $ability];
        } catch (\Exception $exception) {
            $has_access = false;
        }
        return boolval($has_access);
    }

    public function viewAny(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }

    public function print_barcode(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function view(User $user, Product $product)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function create(User $user)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function update(User $user, Product $product)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function delete(User $user, Product $product)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function restore(User $user, Product $product)
    {
        return $this->has_access(__FUNCTION__);

    }


    public function forceDelete(User $user, Product $product)
    {
        return $this->has_access(__FUNCTION__);

    }
}

<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueCode implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        dd($attribute, $value);
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The product code is not unique.';
    }

    public function validate($attribute, $value,$params)
    {
        dd($attribute, $value,$params);
    }
}

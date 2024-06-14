<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            // 'phone' => $this->faker->unique()->safeEmail,
            'address' => $this->faker->address,
            'user_id' => 5365,
            'client_id' => 5365,
            'opening_type' => 'Dr'
        ];
    }
}

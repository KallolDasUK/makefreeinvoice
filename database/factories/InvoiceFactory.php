<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'invoice_number' => 'INV-' . $this->faker->unique()->numberBetween(1000, 9999),
            'order_number' => $this->faker->optional()->numberBetween(1000, 9999),
            'invoice_date' => $this->faker->date(),
            'payment_terms' => $this->faker->optional()->text,
            'due_date' => $this->faker->optional()->date(),
            'customer_id' => \App\Models\Customer::factory(),
            'shipping_date' => $this->faker->optional()->date(),
            'currency' => '₹',
            'sr_id' => $this->faker->optional()->numberBetween(1, 100),
            'is_payment' => true,
            'from_advance' => 0,
            // 'advance' => 0,
            'payment_amount' => $this->faker->randomFloat(2, 100, 5000),
            'payment_method_id' => 66,
            'deposit_to' => $this->faker->numberBetween(1, 300),
            'sub_total' => $this->faker->randomFloat(2, 100, 5000),
            'discount_value' => $this->faker->optional()->numberBetween(0, 100),
            'discount_type' => '%',
            'discount' => $this->faker->randomFloat(2, 0, 100),
            // 'shipping_input' => $this->faker->optional()->text,
            'shipping_charge' => $this->faker->randomFloat(2, 0, 100),
            'total' => $this->faker->randomFloat(2, 100, 5000),
            'recurring_interval' => $this->faker->optional()->word,
            'terms_condition' => $this->faker->optional()->text,
            'notes' => $this->faker->optional()->text,
            'secret' => Str::random(40),
        ];
    }
}

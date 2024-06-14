<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory(100)->create();

        // $customers = Customer::factory()->count(100)->make();

        // foreach ($customers as $customer) {
        //     $data = $customer->only(['name', 'address', 'user_id', 'client_id', 'opening_type']); // Only include columns that exist
        //     Customer::withoutGlobalScopes()->create($data);
        //     // Customer::withoutGlobalScopes()->create($customer->toArray());
        // }
    }
}

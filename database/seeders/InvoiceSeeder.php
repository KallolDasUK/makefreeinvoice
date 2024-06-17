<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $request = [
            "_token" => "0En9acrHQVeRpkIX2UUv0LiXEe9Wa3ZLGlzxxbde",
            "profile_avatar_remove" => null,
            "invoice_number" => "INV-0003",
            "order_number" => null,
            "invoice_date" => "2024-06-14",
            "payment_terms" => null,
            "due_date" => null,
            "customer_id" => "42",
            "shipping_date" => null,
            "currency" => "₹",
            "sr_id" => null,
            "is_payment" => "on",
            "from_advance" => "0",
            // "advance" => "0",
            "payment_amount" => "2000.00",
            "payment_method_id" => "66",
            "deposit_to" => "247",
            "sub_total" => "2000.00",
            "discount_value" => null,
            "discount_type" => "%",
            "discount" => "0.00",
            "shipping_input" => null,
            "shipping_charge" => "0.00",
            "total" => "2000.00",
            "recurring_interval" => "daily",
            "terms_condition" => null,
            "notes" => null,
            "invoice_items" => json_decode('[{"product_id":"2185","description":"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.","price":2000,"qnt":1,"tax_id":"","unit":"1","batch":"","test":"","stock":47}]', true),
            "additional" => [],
        ];

        Invoice::factory()
            ->count(200)
            ->create();
           
    }
}

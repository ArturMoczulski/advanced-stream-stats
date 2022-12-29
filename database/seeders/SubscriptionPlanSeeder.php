<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscription_plans')->insert([
            'name' => 'Annual',
            'billing_cycle' => 12,
            'price' => 99.99,
        ]);

        DB::table('subscription_plans')->insert([
            'name' => 'Monthly',
            'billing_cycle' => 1,
            'price' => 12.99,
        ]);

        DB::table('subscription_plans')->insert([
            'name' => 'Will Trigger Payment Gateway Error Plan',
            'billing_cycle' => 99,
            'price' => 2050.00,
        ]);

    }
}

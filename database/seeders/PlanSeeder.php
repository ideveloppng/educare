<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            ['name' => '1 Month', 'slug' => '1_month', 'price' => 10000, 'duration_months' => 1],
            ['name' => '3 Months', 'slug' => '3_months', 'price' => 27000, 'duration_months' => 3],
            ['name' => '6 Months', 'slug' => '6_months', 'price' => 50000, 'duration_months' => 6],
            ['name' => '1 Year', 'slug' => '1_year', 'price' => 90000, 'duration_months' => 12],
        ];

        foreach ($plans as $plan) {
            \App\Models\Plan::create($plan);
        }
    }
}

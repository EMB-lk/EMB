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
            [
                'name' => 'Basic Profile',
                'slug' => 'basic-profile',
                'description' => 'Free tier with essential features for small businesses',
                'price' => 0.00,
                'billing_period' => 'lifetime',
                'is_free' => true,
                'custom_domain' => false,
                'max_photos' => 5,
                'analytics' => false,
                'priority_support' => false,
                'active' => true,
            ],
            [
                'name' => 'Professional Monthly',
                'slug' => 'professional-monthly',
                'description' => 'Advanced features for growing businesses - Monthly billing',
                'price' => 1500.00,
                'billing_period' => 'monthly',
                'is_free' => false,
                'custom_domain' => true,
                'max_photos' => 50,
                'analytics' => true,
                'priority_support' => true,
                'active' => true,
            ],
            [
                'name' => 'Professional Yearly',
                'slug' => 'professional-yearly',
                'description' => 'Advanced features for growing businesses - Yearly billing (2 months free)',
                'price' => 15000.00,
                'billing_period' => 'yearly',
                'is_free' => false,
                'custom_domain' => true,
                'max_photos' => 50,
                'analytics' => true,
                'priority_support' => true,
                'active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            \App\Models\Plan::create($plan);
        }
    }
}

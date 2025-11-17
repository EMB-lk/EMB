<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Restaurants & Cafes',
                'slug' => 'restaurants-cafes',
                'description' => 'Food and beverage establishments',
                'icon' => 'utensils',
                'template_name' => 'restaurant',
            ],
            [
                'name' => 'Retail & Shopping',
                'slug' => 'retail-shopping',
                'description' => 'Shops, boutiques, and retail stores',
                'icon' => 'shopping-bag',
                'template_name' => 'retail',
            ],
            [
                'name' => 'Health & Medical',
                'slug' => 'health-medical',
                'description' => 'Medical clinics, pharmacies, and health services',
                'icon' => 'heartbeat',
                'template_name' => 'medical',
            ],
            [
                'name' => 'Education & Training',
                'slug' => 'education-training',
                'description' => 'Schools, tutoring centers, and training institutes',
                'icon' => 'graduation-cap',
                'template_name' => 'education',
            ],
            [
                'name' => 'Professional Services',
                'slug' => 'professional-services',
                'description' => 'Legal, accounting, consulting, and other professional services',
                'icon' => 'briefcase',
                'template_name' => 'professional',
            ],
            [
                'name' => 'Automotive',
                'slug' => 'automotive',
                'description' => 'Car repair, sales, and automotive services',
                'icon' => 'car',
                'template_name' => 'automotive',
            ],
            [
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'description' => 'Hardware, furniture, and home improvement',
                'icon' => 'home',
                'template_name' => 'home',
            ],
            [
                'name' => 'Beauty & Wellness',
                'slug' => 'beauty-wellness',
                'description' => 'Salons, spas, and wellness centers',
                'icon' => 'spa',
                'template_name' => 'beauty',
            ],
            [
                'name' => 'Technology & Electronics',
                'slug' => 'technology-electronics',
                'description' => 'Computer shops, mobile services, and electronics',
                'icon' => 'laptop',
                'template_name' => 'technology',
            ],
            [
                'name' => 'Entertainment & Events',
                'slug' => 'entertainment-events',
                'description' => 'Event planning, photography, and entertainment services',
                'icon' => 'camera',
                'template_name' => 'entertainment',
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}

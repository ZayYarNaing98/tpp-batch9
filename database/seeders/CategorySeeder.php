<?php

namespace Database\Seeders;

use App\Models\Category;
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
                'name' => "Travel",
            ],
            [
                'name' => "Education"
            ],
            [
                'name' => "Food and Drink"
            ],
            [
                'name' => "Health & Care"
            ],
        ];

        foreach($categories as $data)
        {
            Category::create($data);
        }
    }
}

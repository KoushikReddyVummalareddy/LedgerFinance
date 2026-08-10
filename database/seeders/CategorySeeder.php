<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Food',
                'type' => 'expense',
            ],
            [
                'name' => 'Transport',
                'type' => 'expense',
            ],
            [
                'name' => 'Housing',
                'type' => 'expense',
            ],
            [
                'name' => 'Shopping',
                'type' => 'expense',
            ],
            [
                'name' => 'Bills',
                'type' => 'expense',
            ],
            [
                'name' => 'Entertainment',
                'type' => 'expense',
            ],
            [
                'name' => 'Health',
                'type' => 'expense',
            ],
            [
                'name' => 'Other expense',
                'type' => 'expense',
            ],
            [
                'name' => 'Salary',
                'type' => 'income',
            ],
            [
                'name' => 'Freelance',
                'type' => 'income',
            ],
            [
                'name' => 'Investment',
                'type' => 'income',
            ],
            [
                'name' => 'Gift',
                'type' => 'income',
            ],
            [
                'name' => 'Other income',
                'type' => 'income',
            ],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                [
                    'name' => $category['name'],
                    'type' => $category['type'],
                ],
                [
                    'updated_at' => now(),
                    'created_at' => now(),
                ],
            );
        }
    }
}
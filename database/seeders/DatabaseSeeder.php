<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_admin' => true
        ]);

        User::factory()->create([
            'name' => 'Second Test User',
            'email' => 'test2@example.com',
            'is_admin' => false
        ]);

        Category::factory(4)
            ->sequence(
            ['category' => 'travel'],
            ['category' => 'entertainment'],
            ['category' => 'global'],
            ['category' => 'groceries'],
            )
            ->create();

        Budget::factory(5)->create(
            ['by_user_id' => 1]
        );
        Budget::factory(5)->create(
            ['by_user_id' => 2]
        );
        
        Transaction::factory(30)
            ->sequence(
                ['in_budget_id' => 1,],
                ['in_budget_id' => 2,],
                ['in_budget_id' => 3,],
                ['in_budget_id' => 4,],
                ['in_budget_id' => 5,]

            )
            ->sequence(
                ['in_category_id' => 1,],
                ['in_category_id' => 2,],
                ['in_category_id' => 3,],
                ['in_category_id' => 4,],
            )
            ->sequence(
                ['owner_id' => 1],
                ['owner_id' => 2]
            )
            ->create();
    }
}

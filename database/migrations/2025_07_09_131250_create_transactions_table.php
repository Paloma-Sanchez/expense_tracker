<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(
                \App\Models\Budget::class,
                'in_budget_id'
            )->constrained('budgets');
            $table->foreignIdFor(
                \App\Models\Category::class,
                'in_category_id'
            )->constrained('categories');
            $table->foreignIdFor(
                \App\Models\User::class,
                'owner_id'
            )->constrained('users');
            $table->float('amount', 10, 2);
            $table->string('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

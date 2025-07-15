<?php

namespace App\Services;

use App\Models\Budget;

class BudgetService {
    public function getAllBudgets($userId) {
        return Budget::where('by_user_id', $userId)->get();
    }
}

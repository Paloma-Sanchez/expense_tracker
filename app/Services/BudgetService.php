<?php

namespace App\Services;

//facades
use Illuminate\Support\Facades\Auth; 

//models
use App\Models\Budget;

class BudgetService {
    public function getAllBudgets() {
        $user = Auth::user();
        return $user->budgets;
    }
}

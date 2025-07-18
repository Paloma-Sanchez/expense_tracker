<?php

namespace App\Services;

use App\Models\Transaction;

//facades
use Illuminate\Support\Facades\Auth; 

class TransactionService {
    public function getAllTransactionsByUserId() {
        $user = Auth::user();
        return $user
                ->transactions()->with('category', 'budget')
                ->orderByDesc('created_at')
                ->paginate(5);
    }

    public function getTransactionsByBudgetId($budgetId, $filters) {

        $user = Auth::user();

        return $user
                ->transactions()
                ->where('in_budget_id', $budgetId)
                ->when(
                    $filters['dateFrom'] ?? false,
                    fn($query, $value) => $query->where('created_at', '>=', $value)
                )
                ->when(
                    $filters['dateTo'] ?? false,
                    fn($query, $value) => $query->where('created_at', '<=', $value)
                )
                ->when(
                    $filters['in_category_id'] ?? false,
                    fn($query, $value) => $query->where('in_category_id', $value)
                )
                ->with('category', 'budget')
                ->orderByDesc('created_at')
                ->get();
        //return $transactions = Transaction::where('in_budget_id', $budgetId)->with('category', 'budget')->get();
    }
}

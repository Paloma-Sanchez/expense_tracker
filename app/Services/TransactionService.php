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

    public function getTransactionsByBudgetId( $request, $budgetId) {
        $filters = $request->only([
            'dateFrom',
            'dateTo',
            'in_catgory_id'
        ]);

        $user = Auth::user();

        $query = $user
                    ->transactions()
                    ->where('in_budget_id', $budgetId);
                    
        if($filters['dateFrom'] ?? false) {
            $query->where('created_at', '>=', $filters['dateFrom']);
        }

        if($filters['dateTo'] ?? false) {
            $query->where('created_at', '<=', $filters['dateTo']);
        }

        if($filters['in_category_id'] ?? false) {
            $query->where('in_category_id', $filters['in_category_id']);
        }

        return $query
                ->with('category', 'budget')
                ->orderByDesc('created_at')
                ->get();
        //return $transactions = Transaction::where('in_budget_id', $budgetId)->with('category', 'budget')->get();
    }
}

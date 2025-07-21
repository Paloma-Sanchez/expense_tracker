<?php
namespace App\Services;

// require 'vendor/autoload.php';

use Carbon\Carbon;

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

        $dateFrom = isset($filters['dateFrom']) && $filters['dateFrom']
            ? Carbon::createFromFormat('d/m/Y', $filters['dateFrom'])->format('Y-m-d')
            : null;
        $dateTo = isset($filters['dateTo']) && $filters['dateTo']
            ? Carbon::createFromFormat('d/m/Y', $filters['dateTo'])->format('Y-m-d')
            : null;


        return $user
            ->transactions()
            ->where('in_budget_id', $budgetId)
            ->when(
                $dateFrom, 
                fn($query, $value) => $query->where('created_at', '>=', $value)
            )
            ->when(
                $dateTo, 
                fn($query, $value) => $query->where('created_at', '<=', $value)
            )
            ->when(
                $filters['in_category_id'] ?? false, 
                fn($query, $value) => $query->where('in_category_id', $value)
                )
            ->with('category', 'budget')
            ->orderByDesc('created_at')
            ->paginate(5);
            // ->withQueryString();
    }

    public function getTransactionsTotalByBudget($budgetId) {
        $user = Auth::user();

        return $user
                ->transactions()
                ->where('in_budget_id', $budgetId)
                ->sum('amount');
    }

    public function getTransactionTotalByBudgetAndCategory($budgetId) {
        $user = Auth::user();

        return $user
            ->transactions()
            ->where('in_budget_id', $budgetId)
            // ->where('amount','<', 0)
            ->join('categories', 'transactions.in_category_id', '=', 'categories.id')
            ->selectRaw('categories.category as name, SUM(transactions.amount) as value')
            ->groupBy('categories.category')
            ->get();
    }
}

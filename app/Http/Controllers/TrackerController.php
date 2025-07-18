<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


//Services
use App\Services\BudgetService;
use App\Services\TransactionService;
use App\Services\CategoryService;


class TrackerController extends Controller
{
    protected $transactionService;
    protected $budgetService;
    protected $categoryService;

    public function __construct(TransactionService $transactionService, BudgetService $budgetService, CategoryService $categoryService) 
    {
        $this->transactionService = $transactionService;
        $this->budgetService = $budgetService;
        $this->categoryService = $categoryService;
    }

    public function index () {
        $transactions = $this->transactionService->getAllTransactionsByUserId();
        $budgets = $this->budgetService->getAllBudgets(1);
        $categories = $this->categoryService->getAllCategories();

        return inertia(
            'Tracker/Index',
            [
                'budgets' => $budgets,
                'categories' => $categories,
                'transactions' => $transactions
            ]
        );
    }
}

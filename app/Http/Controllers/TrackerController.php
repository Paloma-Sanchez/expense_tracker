<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Services\BudgetService;

// controllers
use App\Http\Controllers\CategoryController;


class TrackerController extends Controller
{
    protected $transactionService;
    protected $budgetService;

    public function __construct(TransactionService $transactionService, BudgetService $budgetService, CategoryController $categoryController) 
    {
        $this->transactionService = $transactionService;
        $this->budgetService = $budgetService;
        $this->categoryController = $categoryController;
    }

    public function index () {
        $transactions = $this->transactionService->getAllTransactions();
        $budgets = $this->budgetService->getAllBudgets(1);
        $categories = $this->categoryController->getAllCategories();

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

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBudgetRequest;
use App\Http\Requests\UpdateBudgetRequest;

//Models
use App\Models\Budget;

//Other Controllers
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;

class BudgetController extends Controller
{
    // protected $categoryController

    // public function __construct(TransactionService $transactionService, BudgetService $budgetService, CategoryController $categoryController) 
    // {
    //     $this->categoryController = $categoryController;
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBudgetRequest $request)
    {
       // dd($request->all());
       Budget::create($request->all()); 

       return redirect()->route('tracker');
    }

    /**
     * Display the specified resource.
     */ 
    public function show(Budget $budget) /// revoir
    {
        $transactions = (new TransactionController)->getTransactionsByBudgetId($budget->id);
        $categories = (new CategoryController)->getAllCategories();

        return inertia(
            'Budget/BudgetDetail',
            [
                'budget' => $budget,
                'transactions' => $transactions,
                'categories' => $categories
            ]
            );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBudgetRequest $request, Budget $budget)
    {
        $budget->update(
            $request->all()
        );

        return redirect()->route('budget.show', $budget, 303);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
            // Delete all transactions for this budget
        $budget->transactions()->delete();

        $budget->delete();

        return redirect()->route('tracker', [], 303);
    }

    public function getAllBudgets() {
        return response()->json(Budget::select('id', 'name')->get());
    }
}

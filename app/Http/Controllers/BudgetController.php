<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBudgetRequest;
use App\Http\Requests\UpdateBudgetRequest;
use Illuminate\Http\Request;


//facades
use Illuminate\Support\Facades\Auth; 

//Models
use App\Models\Budget;

//Services
use App\Services\TransactionService;
use App\Services\CategoryService;

class BudgetController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService, CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->transactionService = $transactionService;
        // $this->authorizeResource(Budget::class, 'budget');

    }

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
    public function show(Request $request, Budget $budget) /// revoir
    {
        // if(Auth::user()->cannot('view', $budget)) {
        //     abort(403);
        // } // this works outside controllers

        // $this->authorize('view', $budget); // same as 3 lines above, only in controllers

        $filters = $request->only([
            'dateFrom',
            'dateTo',
            'in_category_id'
        ]);


        $transactions = $this->transactionService->getTransactionsByBudgetId($budget->id, $filters);
        $categories = $this->categoryService->getAllCategories();

        return inertia(
            'Budget/BudgetDetail',
            [
                'budget' => $budget,
                'transactions' => $transactions,
                'categories' => $categories,
                'filters' => $filters
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
        $user = Auth::user();
        return $user->budgets->select('id', 'name')->get();
        //response()->json(Budget::select('id', 'name')->get());
    }
}

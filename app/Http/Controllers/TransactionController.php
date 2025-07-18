<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use Illuminate\Http\Request;

//facades
use Illuminate\Support\Facades\Auth; 

//models
use App\Models\Transaction;

class TransactionController extends Controller
{
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
    public function store(Request $request)
    {
        \Log::info('Requeste', $request->all());

        $validated = $request->validate([
            'amount' => 'required|numeric|decimal:0,2|max:1000000|min:-1000000',
            'description' => 'required|string|min:1|max:100',
            'in_category_id' => 'required|exists:categories,id',
            'in_budget_id' => 'required|exists:budgets,id',
            'owner_id' => 'required|exists:users,id',
        ]);

        Transaction::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Transaction created');

    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        \Log::info('Update payload:', $request->all());

        $validated = $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'in_category_id' => 'required|exists:categories,id',
            // ... any other fields
        ]);

        $transaction->update($validated);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $budget_id = $transaction->in_budget_id; // <-- this is the correct way
        $transaction->delete();

        return redirect()->route('budget.show', $budget_id, 303);
    }

    //Custom functions
    public function getTransactionsByBudgetId( $filters, $budgetId) {

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

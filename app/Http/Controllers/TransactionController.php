<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use Illuminate\Http\Request;

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
            'amount' => 'required|decimal:2|max:1000000|min:-1000000',
            'description' => 'required|string|min:1|max:100',
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
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {   
        \Log::info('Transaction update payload:', $request->all());
    
        $transaction->update(
            $request->only(
                'description',
                'amount',
                'in_category_id'
            )
        );
    
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
    public function getTransactionsByBudgetId($budgetId) {
        return $transactions = Transaction::where('in_budget_id', $budgetId)->with('category', 'budget')->get();
    }
}

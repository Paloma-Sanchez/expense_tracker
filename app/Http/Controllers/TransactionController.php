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
        $request->session()->forget('success');

        $validated = $request->validate([
            'amount' => 'required|numeric|decimal:0,2|max:1000000|min:-1000000',
            'description' => 'required|string|min:1|max:100',
            'in_category_id' => 'required|exists:categories,id',
            'in_budget_id' => 'required|exists:budgets,id',
            'owner_id' => 'required|exists:users,id',
        ]);

        $transaction = Transaction::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Transaction created  ' . $transaction->id);

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
            'amount' => 'required|numeric|decimal:0,2|min:-1000000|max:1000000',
            'in_category_id' => 'required|exists:categories,id',
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
}

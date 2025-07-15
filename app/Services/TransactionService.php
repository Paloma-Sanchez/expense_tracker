<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionService {
    public function getAllTransactions() {
        return Transaction::with('category', 'budget')->get();
    }
}

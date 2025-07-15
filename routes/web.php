<?php

use Illuminate\Support\Facades\Route;

//Controllers
use App\Http\Controllers\IndexController;
use App\Http\Controllers\TrackerController;

//Ressource controllers
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;


Route::get('/', [IndexController::class, 'index']);
Route::get('/tracker', [TrackerController::class, 'index'])->name('tracker');

//Categories
Route::get('/categories/all', [CategoryController::class, 'getAllCategories']);

//Budgets
Route::resource('/budget', BudgetController::class);//->only(['show', 'store', 'destroy']);
Route::get('/budgets/all', [BudgetController::class, 'getAllBudgets']);

//transactions
Route::resource('/transaction', TransactionController::class)->except(['show']);


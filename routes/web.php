<?php

use Illuminate\Support\Facades\Route;

//Controllers
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrackerController;
use App\Http\Controllers\UserAccountController;

//Ressource controllers
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;


Route::get('/', [IndexController::class, 'index']);
Route::get('/tracker', [TrackerController::class, 'index'])
  ->name('tracker')
  ->middleware('auth');;

//Login
Route::get('login', [AuthController::class, 'create'])
  ->name('login');
Route::post('login', [AuthController::class, 'store'])
  ->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])
  ->name('logout');

Route::resource('user-account', UserAccountController::class)
  ->only('create', 'store'); 

//Categories
Route::get('/categories/all', [CategoryController::class, 'getAllCategories'])
  ->middleware('auth');;

//Budgets
Route::resource('/budget', BudgetController::class)
  ->middleware('auth');//->only(['show', 'store', 'destroy']);
Route::get('/budgets/all', [BudgetController::class, 'getAllBudgets'])
  ->middleware('auth');;

//transactions
Route::resource('/transaction', TransactionController::class)
  ->except(['show', 'edit', 'create', 'index'])
  ->middleware('auth');


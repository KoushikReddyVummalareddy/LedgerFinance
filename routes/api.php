<?php

use Illuminate\Support\Facades\Route;
use Src\Http\Controllers\AuthController;
use Src\Http\Controllers\CategoryController;
use Src\Http\Controllers\DashboardController;
use Src\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ]);

    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */

    Route::get('/categories', [
        CategoryController::class,
        'index'
    ]);

    Route::post('/categories', [
        CategoryController::class,
        'store'
    ]);

    Route::put('/categories/{id}', [
        CategoryController::class,
        'update'
    ]);

    Route::delete('/categories/{id}', [
        CategoryController::class,
        'destroy'
    ]);

    /*
    |--------------------------------------------------------------------------
    | Transactions
    |--------------------------------------------------------------------------
    */

    Route::get('/transactions', [
        TransactionController::class,
        'index'
    ]);

    Route::post('/transactions', [
        TransactionController::class,
        'store'
    ]);

    Route::put('/transactions/{id}', [
        TransactionController::class,
        'update'
    ]);

    Route::delete('/transactions/{id}', [
        TransactionController::class,
        'destroy'
    ]);

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [
        AuthController::class,
        'logout'
    ]);
});
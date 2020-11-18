<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::name('user.')->group(function() {

    Route::get('/dashboard', [MainController::class, 'index'])->name('dashboard');
    Route::get('/roles', [MainController::class, 'index'])->name('roles')->middleware('admin');
    Route::get('/users', [MainController::class, 'index'])->name('users')->middleware('admin');
    Route::get('/expense-categories', [MainController::class, 'index'])->name('categories')->middleware('admin');
    Route::get('/expenses', [MainController::class, 'index'])->name('expenses');
    Route::get('/settings', [MainController::class, 'index'])->name('settings');

    Route::resource('/expenses', MainController::class);
});

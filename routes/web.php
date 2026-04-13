<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ItemController as AdminItemController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Operator\ItemController as OperatorItemController;
use App\Http\Controllers\Operator\LendingController;
use App\Http\Controllers\Operator\UserController as OperatorUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class)->except('show');
    Route::get('/categories/export', [CategoryController::class, 'export'])->name('categories.export');

    Route::get('/items/export', [AdminItemController::class, 'export'])->name('items.export');
    Route::get('/items/{item}/lendings', [AdminItemController::class, 'lendingDetails'])->name('items.lendings');
    Route::get('/items/{item}', [AdminItemController::class, 'show'])->name('items.show');
    Route::delete('/items/{item}', [AdminItemController::class, 'destroy'])->name('items.destroy');
    Route::resource('items', AdminItemController::class)->except('show', 'destroy');

    Route::get('/users/admin', [AdminUserController::class, 'adminIndex'])->name('users.admin');
    Route::get('/users/operator', [AdminUserController::class, 'operatorIndex'])->name('users.operator');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
    Route::get('/users/admin/export', [AdminUserController::class, 'exportAdmin'])->name('users.export-admin');
    Route::get('/users/operator/export', [AdminUserController::class, 'exportOperator'])->name('users.export-operator');
});

Route::middleware(['auth', 'role:operator'])->prefix('operator')->name('operator.')->group(function () {
    Route::get('/dashboard', [OperatorDashboardController::class, 'index'])->name('dashboard');

    Route::get('/lendings', [LendingController::class, 'index'])->name('lendings.index');
    Route::get('/lendings/create', [LendingController::class, 'create'])->name('lendings.create');
    Route::post('/lendings', [LendingController::class, 'store'])->name('lendings.store');
    // Route::post('/lendings/{lending}/returned', [LendingController::class, 'returned'])->name('lendings.returned');
    // Route::delete('/lendings/{lending}', [LendingController::class, 'destroy'])->name('lendings.destroy');
    // Route::get('/lendings/export', [LendingController::class, 'export'])->name('lendings.export');

    // Route::get('/items', [OperatorItemController::class, 'index'])->name('items.index');

    // Route::get('/users/{user}/edit', [OperatorUserController::class, 'edit'])->name('users.edit');
    // Route::put('/users/{user}', [OperatorUserController::class, 'update'])->name('users.update');
});

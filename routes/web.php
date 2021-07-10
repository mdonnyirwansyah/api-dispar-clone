<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsCategoryController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', DashboardController::class)->name('dashboard');

Route::prefix('news')->name('news.')->group(function () {
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('', [NewsCategoryController::class, 'index'])->name('index');
        Route::get('create', [NewsCategoryController::class, 'create'])->name('create');
        Route::post('', [NewsCategoryController::class, 'store'])->name('store');
        Route::get('edit/{category:slug}', [NewsCategoryController::class, 'edit'])->name('edit');
        Route::put('{category:slug}', [NewsCategoryController::class, 'update'])->name('update');
        Route::delete('{category:slug}', [NewsCategoryController::class, 'destroy'])->name('destroy');
    });
});

<?php

use App\Livewire\Admin\Category\CategoryIndex;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Product\ProductIndex;
use App\Livewire\Admin\Product\ProductUpdate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

ROute::middleware(['auth'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/dashboard', Dashboard::class)->name('dashboard.index');
    Route::get('/categories', CategoryIndex::class)->name('categories.index');
    Route::get('/products', ProductIndex::class)->name('products.index');
    Route::get('/products/{id}/edit', ProductUpdate::class)->name('products.update');
});

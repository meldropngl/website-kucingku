<?php
use App\Models\Category;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardProductController;
use App\Http\Controllers\DashboardOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\OrderController;

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

Route::get('/', [HomeController::class, 'index']);

Route::get('/product/{id}', [ProductController::class, 'index']);
Route::post('/product/{id}', [ProductController::class, 'cart']);

Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart', [CartController::class, 'deleteCart']);

Route::group(['middleware' => ['guest']], function(){
    Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::group(['middleware' => ['auth', 'checkLevels:admin']], function(){
    Route::resource('/dashboard/products', DashboardProductController::class)->middleware('auth');
    Route::resource('/dashboard/orders', DashboardOrderController::class)->middleware('auth');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('login')->middleware('auth');
    Route::post('/logout', [LoginController::class, 'logout'])->name('login')->middleware('auth');

});

Route::group(['middleware' => ['auth']], function(){
    Route::post('/logout', [LoginController::class, 'logout'])->name('login')->middleware('auth');

    Route::post('/invoice', [InvoiceController::class, 'index'])->name('login')->middleware('auth');
     Route::post('/invoice/{id}', [InvoiceController::class, 'buy'])->name('login')->middleware('auth');

    Route::get('/transaction', [TransactionController::class, 'index'])->name('login')->middleware('auth');
    Route::post('/transaction/{id}', [TransactionController::class, 'store'])->name('login')->middleware('auth');
});
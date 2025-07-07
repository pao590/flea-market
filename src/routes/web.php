<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;

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


Route::middleware('auth')->group(function () {

    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::post('/items/{item}/like', [ItemController::class, 'like'])->name('items.like');

    Route::post('/items/{item}/unlike', [ItemController::class, 'unlike'])->name('items.unlike');

    Route::put('/item/{item}', [ItemController::class, 'update'])->name('items.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchases.index');

    Route::get('/purchase/address', [PurchaseController::class, 'address'])->name('purchases.address');

    Route::get('/purchase/address', [PurchaseController::class, 'address'])->name('purchases.address');

    Route::post('/purchase/address', [PurchaseController::class, 'updateAddress'])->name('purchases.updateAddress');

});

Route::get('/', [ItemController::class, 'index'])->name('items.index');

Route::get('/item/{item}', [ItemController::class, 'show'])->name('items.show');

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');

Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::post('/login', [AuthController::class, 'login']);

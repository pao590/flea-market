<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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
    Route::post('/purchase/address', [PurchaseController::class, 'updateAddress'])->name('purchases.updateAddress');
    Route::post('/purchase/{item}', [PurchaseController::class, 'store'])->name('purchases.store');

    Route::get('/item/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/item/store', [ItemController::class, 'store'])->name('items.store');

    Route::get('/mypages', [MypageController::class, 'index'])->name('mypages.index');

    Route::get('/mypages/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypages/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/mypages/setup', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/mypages/setup', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/mypages/mylist', [MypageController::class, 'mylist'])->name('mypages.mylist');
});

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('/mypages/setup', [ProfileController::class, 'create'])->name('profile.create');
//     Route::post('/mypages/setup', [ProfileController::class, 'store'])->name('profile.store');
// });

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/', [ItemController::class, 'index'])->name('items.index');

Route::get('/item/{item}', [ItemController::class, 'show'])->name('items.show');

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');

Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::post('/login', [AuthController::class, 'login']);

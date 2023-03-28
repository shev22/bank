<?php

use Illuminate\Support\Facades\Auth;
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
Auth::routes();
Route::get('/', function () {
    return view('frontend.index');
});



Route::get('login/google/redirect', [App\Http\Controllers\Auth\SocialController::class, 'googleRedirect'])->name('googleRedirect');
Route::get('login/google/callback', [App\Http\Controllers\Auth\SocialController::class, 'googleCallback'])->name('googleCallback');

Route::get('login/github/redirect', [App\Http\Controllers\Auth\SocialController::class, 'githubRedirect'])->name('githubRedirect');
Route::get('login/github/callback', [App\Http\Controllers\Auth\SocialController::class, 'githubCallback'])->name('githubCallback');

Route::get('login/facebook/redirect', [App\Http\Controllers\Auth\SocialController::class, 'facebookRedirect'])->name('facebookRedirect');
Route::get('login/facebook/callback', [App\Http\Controllers\Auth\SocialController::class, 'facebookCallback'])->name('facebookCallback');


Route::post('/create-account', [App\Http\Controllers\AccountController::class, 'createAccount'])->name('createAccount');
Route::post('/account', [App\Http\Controllers\AccountController::class, 'account'])->name('account');



Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Frontend\FrontendController::class, 'dashboard'])->name('dashboard');


    Route::get('/operations', [App\Http\Controllers\OperationsController::class, 'index'])->name('operations');


    Route::get('/transactions', [App\Http\Controllers\TransactionController::class, 'index'])->name('transactions');
    Route::post('/transactions', [App\Http\Controllers\TransactionController::class, 'index'])->name('transactions');
    Route::get('/email', [App\Http\Controllers\TransactionController::class, 'statement'])->name('statement');
    Route::post('/view', [App\Http\Controllers\TransactionController::class, 'viewStatement'])->name('view');
    Route::post('/read_notifications', [App\Http\Controllers\TransactionController::class, 'readNotification'])->name('notification');


    Route::post('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');

   

});


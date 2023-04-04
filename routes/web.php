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
Route::post('/account', [App\Http\Controllers\AccountController::class, 'getAccountDetail'])->name('account');
Route::post('/delete-account', [App\Http\Controllers\AccountController::class, 'deleteAccount'])->name('delete-account');



Route::middleware(['auth'])->group(function () {


  
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
    Route::post('/role', [App\Http\Controllers\AdminController::class, 'role'])->name('role');
    Route::post('/edit', [App\Http\Controllers\AdminController::class, 'edit'])->name('edit');
    Route::post('/update', [App\Http\Controllers\AdminController::class, 'update'])->name('update');
    Route::post('/delete', [App\Http\Controllers\AdminController::class, 'delete'])->name('delete');

    Route::post('/operations', [App\Http\Controllers\AdminController::class, 'operations'])->name('operations');
    // Route::post('/destroy', [App\Http\Controllers\AdminController::class, 'destroy'])->name('destroy');
     Route::post('/actions', [App\Http\Controllers\AdminController::class, 'updateCurrency'])->name('update-currency');
    



    Route::get('/dashboard', [App\Http\Controllers\Frontend\FrontendController::class, 'dashboard'])->name('dashboard');

    Route::get('/operations', [App\Http\Controllers\OperationsController::class, 'index'])->name('operations');

    Route::get('/transactions', [App\Http\Controllers\TransactionController::class, 'index'])->name('transactions');
    Route::post('/transactions', [App\Http\Controllers\TransactionController::class, 'index'])->name('transactions');
    Route::get('/email', [App\Http\Controllers\TransactionController::class, 'statement'])->name('statement');
    Route::post('/view', [App\Http\Controllers\TransactionController::class, 'viewStatement'])->name('view');
    Route::post('/read_notifications', [App\Http\Controllers\TransactionController::class, 'readNotification'])->name('notification');


    Route::post('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');

    Route::post('/currency', [App\Http\Controllers\AccountTypeController::class, 'currency'])->name('currency');
   

   

});


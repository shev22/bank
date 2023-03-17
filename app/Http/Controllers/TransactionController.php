<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        // $accountsTypes = $this->accountService->getAccountCurrencies();
      
        $transactions = Transaction::where('user_id', Auth::id())->get();
        return view('frontend.transaction', ['transactions'=> $transactions]);
    }
}

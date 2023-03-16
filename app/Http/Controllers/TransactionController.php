<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        // $accountsTypes = $this->accountService->getAccountCurrencies();
      
      
        return view('frontend.transaction');
    }
}

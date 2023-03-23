<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Services\AccountService;
use App\Http\Controllers\Services\TransactionService;

class TransactionController extends Controller
{
    private $transactionService;
    private $accountService;
  

    public function __construct(TransactionService $transactionService, AccountService $accountService)
    {
        $this->transactionService = $transactionService;
        $this->accountService = $accountService;
    }

    public function readNotification(Request $request)
    {
        $this->transactionService->readNotification($request); 
    }

    public function statement(Request $request)
    {
        $this->transactionService->statement($request); 
    }
    

    public function index(Request $request)
    {
        $accounts = $this->accountService->getUserAccounts();
        $transactions = $this->transactionService->getTransactions($request); 
        $notifications =  $this->transactionService->getNotifications(); 
        return view('frontend.transaction', ['transactions'=> $transactions,
                                              'accounts'=> $accounts,
                                              'notifications'      => $notifications['notifications'],
                                              'newMessage'      => $notifications['newMessage']
                                              ]);
    }
}

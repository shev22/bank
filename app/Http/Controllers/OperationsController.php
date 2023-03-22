<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Services\AccountService;
use App\Http\Controllers\Services\TransactionService;

class OperationsController extends Controller
{
    private $accountService;
    private $transactionService;

    public function __construct(TransactionService $transactionService, AccountService $accountService)
    {
        $this->accountService = $accountService;
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        $accountsTypes = $this->accountService->getAccountCurrencies();
        $notifications =  $this->transactionService->getNotifications(); 
        return view('frontend.operations', [
            'accounts_types' => $accountsTypes,
            'notifications'      => $notifications['notifications'],
            'newMessage'      => $notifications['newMessage']
        ]);
    }
}

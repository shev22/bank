<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Services\AdminService;
use App\Http\Controllers\Services\AccountService;
use App\Http\Controllers\Services\TransactionService;

class OperationsController extends Controller
{
    private $accountService;
    private $transactionService;
    private $adminService;

    public function __construct(TransactionService $transactionService, AccountService $accountService,   AdminService $adminService)
    {
        $this->accountService = $accountService;
        $this->transactionService = $transactionService;
        $this->adminService = $adminService;
    }

    public function index()
    {
        $accountsTypes = $this->accountService->getAccountCurrencies();
        $notifications =  $this->transactionService->getNotifications(); 
        $currencies = $this->adminService->currencyAPI();
        return view('frontend.operations', [
           'accounts_types' => $accountsTypes, 
           'currencies' => $currencies,
            'notifications'      => $notifications['notifications'],
            'newMessage'      => $notifications['newMessage']
        ]);
    }
}

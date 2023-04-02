<?php

namespace App\Http\Controllers\Frontend;



use App\Http\Controllers\Controller;
use App\Http\Controllers\Services\AdminService;
use App\Http\Controllers\Services\AccountService;
use App\Http\Controllers\Services\TransactionService;

class FrontendController extends Controller
{
    public const DASHBOARD = '/dashboard';
    private $accountService;
    private $adminService;
    private $transactionService;

    public function __construct(AccountService $accountService, TransactionService $transactionService,  AdminService $adminService )
    {
        
        $this->adminService = $adminService;
        $this->accountService = $accountService;
        $this->transactionService = $transactionService;
    }









    public function dashboard()
    {
        $currencies = $this->adminService->currencyAPI();
        $accountsTypes =  $this->accountService->getAccountCurrencies();
        $accounts =  $this->accountService->getUserAccounts();
        $notifications =  $this->transactionService->getNotifications(); 
        return view('frontend.dashboard',[

            'accounts_types'=> $accountsTypes,
            'accounts'      => $accounts,
            'currencies' => $currencies,
           'notifications'      => $notifications['notifications'],
            'newMessage'      => $notifications['newMessage']
        
        ]);
    }


   
}

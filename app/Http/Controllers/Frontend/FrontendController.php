<?php

namespace App\Http\Controllers\Frontend;

use view;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Services\AccountService;
use App\Http\Controllers\Services\TransactionService;

class FrontendController extends Controller
{
    public const DASHBOARD = '/dashboard';
    private $accountService;
    private $transactionService;

    public function __construct(AccountService $accountService, TransactionService $transactionService )
    {
        $this->accountService = $accountService;
        $this->transactionService = $transactionService;
    }









    public function dashboard()
    {
       
        $accountsTypes =  $this->accountService->getAccountCurrencies();
        $accounts =  $this->accountService->getUserAccounts();
        $notifications =  $this->transactionService->getNotifications(); 
        return view('frontend.dashboard',[

            'accounts_types'=> $accountsTypes,
            'accounts'      => $accounts,
           'notifications'      => $notifications['notifications'],
            'newMessage'      => $notifications['newMessage']
        
        ]);
    }


   
}

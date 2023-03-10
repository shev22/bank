<?php

namespace App\Http\Controllers\Frontend;

use view;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Services\AccountService;
use App\Models\Account;

class FrontendController extends Controller
{
    public const DASHBOARD = '/dashboard';
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }









    public function dashboard()
    {
       
        $accountsTypes =  $this->accountService->getAccountCurrencies();
        $accounts =  $this->accountService->getUserAccounts();
        return view('frontend.dashboard',[

            'accounts_types'=> $accountsTypes,
            'accounts'      => $accounts
        
        ]);
    }


   
}

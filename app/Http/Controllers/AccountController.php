<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Services\AccountService;

class AccountController extends Controller
{
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function createAccount(Request $request)
    {
    
        $createdAccountNumbers = [$this->accountService->getCreatedAccounts()];
        $createdAccountCurrencies = $this->accountService->getCreatedAccountCurrenciesForSpecificUser();
        $account_number = substr(str_shuffle('0123456789'), 0, 7);
        $account_number .= substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0,2 );

        if (!in_array($account_number, $createdAccountNumbers)) { 
                if ( in_array($request->account_currency, $createdAccountCurrencies)) 
                    {
                        //alertify.notify('Account Currency Already Exists');
                        dd('Account Currency Already Exists');
                    }else{
                        $account = Account::create([
                            'user_id' => Auth::id(),
                            'account_name' => $request->account_name,
                            'account_number' => $account_number,
                            'account_currency' => $request->account_currency,
                        ]);
                            return redirect()->route('dashboard');
                            dd('Account Created Successfully');
                             //alertify.notify('Account Created Successfully');
                    }
        }else{
              //alertify.notify('Account number DB full');
          dd('Account number DB full');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
        $validatedData = $request->validate([
           'account_name' => 'required|max:255',
            
        ]);
       
        $createdAccountNumbers = [$this->accountService->getCreatedAccounts()];
        $createdAccountCurrencies = $this->accountService->getCreatedAccountCurrenciesForSpecificUser();
        $account_number = substr(str_shuffle('0123456789'), 0, 7);
        $account_number .= substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0,2 );

        if (!in_array($account_number, (array)$createdAccountNumbers)) { 
                if ( in_array($request->account_currency_id, (array)$createdAccountCurrencies)) 
                    {
                        Session::flash('message', 'Account Currency Already Exists!'); 
                        Session::flash('alert-class', 'alert-danger');  
                        return redirect()->route('dashboard');
                    }else{
                        Account::create([
                            'user_id' => Auth::id(),
                            'account_currency_id' => $request->account_currency_id,
                            'account_name' => $request->account_name,
                            'account_number' => $account_number,
                            // 'account_currency' => $request->account_currency,
                        ]);    
                                        
                             Session::flash('message', 'Account Created Successfully!'); 
                             Session::flash('alert-class', 'alert-success'); 
                             return redirect()->route('dashboard');
                    }
        }else{
          Session::flash('message', 'Account number DB full'); 
          Session::flash('alert-class', 'alert-danger'); 
          return redirect()->route('dashboard');
        }
    }


    public function account(Request $request)
    {
            $account = Account::where('user_id', Auth::id())
                                    ->where('id', $request->id)
                                    ->first();

            $user_account = [
                'name' =>   $account->account_name,
                'number' =>  $account->account_number,
                'balance' =>$account->accounType->account_currency.$account->account_balance,
                'created_at' => Carbon::parse($account->created_at)->format('d/m/Y'),
            ];                 

           $data = ['account' => $user_account, 'id'=>$request->id];
           echo json_encode($data);                
    }

    }


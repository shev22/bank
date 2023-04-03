<?php
/**
 * Created by PhpStorm.
 * User: Francois
 * Date: 7.03.2023
 * Time: 8:37
 */

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AccountRepository
 {

    public function getAccountTypes()
    {
        $account_types = AccountType::all()->toArray();
        return $account_types;
    }

    public function getUserAccounts()
    {
        $accounts = Account::where('user_id', Auth::id())->get();
        return $accounts;
    }
    
    public function getCreatedAccounts()
    {
        $accounts = Account::all()->pluck('account_number')->toArray();
       
        return $accounts;
    }

    public function getCreatedAccountCurrenciesForSpecificUser()
    {
        $accounts = Account::where('user_id', Auth::id())->pluck('account_currency_id')->toArray();
        return $accounts;
    }

    public function createAccount( $request)
    {
        $createdAccountNumbers = [$this->getCreatedAccounts()];
        $createdAccountCurrencies = $this->getCreatedAccountCurrenciesForSpecificUser();
        $account_number = substr(str_shuffle('0123456789'), 0, 7);
        $account_number .= substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0,2 );

        if (!in_array($account_number, $createdAccountNumbers)) { 
                if ( in_array($request->account_currency, $createdAccountCurrencies)) 
                    {
                        Session::flash('message', 'Account Currency Already Exists!'); 
                        Session::flash('alert-class', 'alert-danger');  
                        return redirect()->route('dashboard');
                    }else{
                     
                        Account::create([
                            'user_id' => Auth::id(),
                            'account_currency_id' => $request->account_currency,
                            'account_name' => $request->account_name,
                            'account_number' => $account_number,
                             'account_currency' => AccountType::getCurrencySymbol($request->account_currency_id),
                        ]);    
                                        
                             Session::flash('message', 'Account Created Successfully!'); 
                             Session::flash('alert-class', 'alert-success'); 
                          
                    }
        }else{
          Session::flash('message', 'Account number DB full'); 
          Session::flash('alert-class', 'alert-danger'); 
          return redirect()->route('dashboard');
        }
    }


    public function getAccountDetail($request)
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
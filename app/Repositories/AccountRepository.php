<?php
/**
 * Created by PhpStorm.
 * User: Francois
 * Date: 7.03.2023
 * Time: 8:37
 */

namespace App\Repositories;

use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Support\Facades\Auth;

class AccountRepository
 {

    public function getAccountTypes(): array
    {
        $account_types = AccountType::all()->toArray();
        return $account_types;
    }

    public function getUserAccounts()
    {
        $accounts = Account::where('user_id', Auth::id())->get();
        return $accounts;
    }
    
    public function getCreatedAccounts(): array
    {
        $accounts = Account::all()->pluck('account_number')->toArray();
        return $accounts;
    }

    public function getCreatedAccountCurrenciesForSpecificUser(): array
    {
        $accounts = Account::where('user_id', Auth::id())->pluck('account_currency')->toArray();
        return $accounts;
    }

    
 }
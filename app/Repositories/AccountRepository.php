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

    private function getCreatedAccounts()
    {
        $accounts = Account::all()
            ->pluck('account_number')
            ->toArray();

        return $accounts;
    }

    private function getCreatedAccountCurrenciesForSpecificUser(array $array)
    {
        $accounts = Account::where('user_id', Auth::id())
            ->whereIn('account_currency_id', $array)
            ->get();
        $toarray = collect($accounts)->toArray();
        return $toarray;
    }

    private function createAccountNumber(): string
    {
        $account_number = substr(str_shuffle('0123456789'), 0, 7);
        $account_number .= substr(
            str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),
            0,
            2
        );
        return $account_number;
    }

    public function createAccount($request)
    {
       
        $createdAccountNumbers = [$this->getCreatedAccounts()];
        $createdAccountCurrencies = $this->getCreatedAccountCurrenciesForSpecificUser(
            $request->account_currency
        );
       // dump( $createdAccountCurrencies);
        if (!in_array($this->createAccountNumber(), $createdAccountNumbers)) {
            foreach ($request->account_currency as $currency) {
                if (!$createdAccountCurrencies == []) {
                    Session::flash('message', 'Already Added!');
                    Session::flash('alert-class', 'alert-danger');
                } else {
                    Account::create([
                        'user_id' => Auth::id(),
                        'account_currency_id' => $currency,
                        'account_name' => $request->account_name,
                        'account_number' => $this->createAccountNumber(),
                        // 'account_currency' => AccountType::getCurrencySymbol(
                        //     $request->account_currency_id
                        // ),
                    ]);

                    Session::flash('message', 'Created Successfully!');
                    Session::flash('alert-class', 'alert-success');
                }
            }
        } else {
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
            'id' => $account->id,
            'name' => $account->account_name,
            'number' => $account->account_number,
            'balance' =>
                $account->accounType->account_currency .
                $account->account_balance,
            'created_at' => Carbon::parse($account->created_at)->format(
                'd/m/Y'
            ),
        ];

        $data = ['account' => $user_account, 'id' => $request->id];
        echo json_encode($data);
    }

    public function deleteAccount($request)
    {
        $account = Account::findOrFail($request->id);

        if(  $account->account_balance > 0)
        {
            Session::flash("message', 'Account Balance above '0'!");
            Session::flash('alert-class', 'alert-danger');
        }else{
            $account->delete();
            Session::flash('message', 'Account Removed!');
            Session::flash('alert-class', 'alert-success');
        }
               
          
    }

}

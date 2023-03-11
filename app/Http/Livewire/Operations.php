<?php

namespace App\Http\Livewire;

use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Operations extends Component
{
    public $account_id;
    public $currency;
    public $balance;
    public $accountName;
    public $depositAmount;

    public function rules()
    {
        return [
            'depositAmount' => 'required|string|max:80',
        ];
    }

    public function resetInput()
    {
        $this->depositAmount = null;
   
    }

    public function getSelectedAccount(): void
    {
        $activeAccounts = Account::where('id', $this->account_id)->get();

        foreach ($activeAccounts as $activeAccount) {
            $this->currency = $activeAccount->account_currency;
            $this->balance = $activeAccount->account_balance;
            $this->accountName = $activeAccount->account_name;
        }
    }

    public function deposit()
    {
        if (!$this->account_id) {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Please Select an Account',
            ]);
        } else {
            $validatedData = $this->validate();
            $accounts = Account::where('user_id', Auth::id())
                ->where('id', $this->account_id)
                ->get();
            if ($accounts) {
                foreach ($accounts as $account) {
                    $account->account_balance += $this->depositAmount;
                    $account->update();
                    $this->balance =  $account->account_balance;
                }
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Deposit Successfull',
                ]);

                $this->resetInput();
            } else {
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Something went wrong',
                ]);
            }
        }
    }
  

    public function render()
    {
        $accounts = Account::where('user_id', Auth::id())->get();
        return view('livewire.operations', [
            'accounts' => $accounts,
        ]);
    }
}

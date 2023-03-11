<?php

namespace App\Http\Livewire;

use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Operations extends Component
{
    public $fromGuestAccount;
    public $toGuestAccount;
    public $accountName;
    public $fromBalance;
    public $fromAccount;
    public $account_id;
    public $fromSymbol;
    public $toBalance;
    public $toAccount;
    public $toSymbol;
    public $currency;
    public $balance;
    public $amount;
    public $symbol;

    public function rules()
    {
        return [
            'amount' => 'required|string|max:80',
        ];
    }

    public function resetInput()
    {
        $this->amount = null;
    }

    public function getSelectedAccount(): void
    {
        $activeAccounts = Account::where('user_id', Auth::id())
            ->where('id', $this->account_id)
            ->get();
        $this->loadData($activeAccounts);
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
                    $account->account_balance += $this->amount;
                    $account->update();
                    $this->balance = $account->account_balance;
                }
                $this->dispatchBrowserEvent('message', [
                    'text' =>
                        'Deposit of ' .
                        $this->symbol .
                        $this->amount .
                        ' Successfull',
                ]);

                $this->resetInput();
            } else {
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Something went wrong',
                ]);
            }
        }
    }

    public function withdraw()
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
                    if ($account->account_balance >= $this->amount) {
                        $account->account_balance -= $this->amount;
                        $account->update();
                        $this->balance = $account->account_balance;
                        $this->dispatchBrowserEvent('message', [
                            'text' =>
                                'Withdrawal of ' .
                                $this->symbol .
                                $this->amount .
                                ' Successfull',
                        ]);
                        $this->resetInput();
                    } else {
                        $this->dispatchBrowserEvent('message', [
                            'text' => 'Insufficient Balance',
                        ]);
                    }
                }
            } else {
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Something went wrong',
                ]);
            }
        }
    }

    public function transfer(): void
    {
        if (!$this->fromAccount || !$this->toAccount) {
            $this->dispatchBrowserEvent('message', [
                'text' => ' Select Transfer Accounts',
            ]);
        } else {
             $validatedData = $this->validate();

            $accountsArray = [$this->fromAccount, $this->toAccount];
            $accounts = Account::whereIn('id', $accountsArray)->get();

             foreach ($accounts as $account) {
                if ($this->fromAccount == $this->toAccount) {
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Select Different Accounts',
                    ]);
                } else {
                     if ($account->id == $this->fromAccount) {
                        if ($account->account_balance >= $this->amount) {
                            $account->account_balance -= $this->amount;
                            $account->update();
                            $this->fromBalance = $account->account_balance;
                            $this->dispatchBrowserEvent('message', [
                        'text' => 'Tranfer Completed',
                     ]);
                        } else {
                            $this->dispatchBrowserEvent('message', [
                                'text' => 'Insufficient Balance',
                            ]);
                        }
                     }
                    if ($account->id == $this->toAccount) {
                        $account->account_balance += $this->amount;
                        $account->update();
                        $this->toBalance = $account->account_balance;
                    }
           
              }
             }
        }
    }

    public function fromAccount(): void
    {
        $activeAccounts = Account::where('user_id', Auth::id())
            ->where('id', $this->fromAccount)
            ->get();

        foreach ($activeAccounts as $activeAccount) {
            $this->fromBalance = $activeAccount->account_balance;
            $this->fromSymbol = $activeAccount->accounType->account_currency;
        }
    }

    public function toAccount(): void
    {
        $activeAccounts = Account::where('user_id', Auth::id())
            ->where('id', $this->toAccount)
            ->get();

        foreach ($activeAccounts as $activeAccount) {
            $this->toBalance = $activeAccount->account_balance;
            $this->toSymbol = $activeAccount->accounType->account_currency;
        }
    }

    private function loadData($activeAccounts): void
    {
        foreach ($activeAccounts as $activeAccount) {
            $this->currency = $activeAccount->accounType->account_symbol;
            $this->balance = $activeAccount->account_balance;
            $this->accountName = $activeAccount->account_name;
            $this->symbol = $activeAccount->accounType->account_currency;
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

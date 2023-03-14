<?php

namespace App\Http\Livewire;

use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Operations extends Component
{
    public $fromCurrency;
    public $accountName;
    public $fromBalance;
    public $fromAccount;
    public $toCurrency;
    public $account_id;
    public $fromSymbol;
    public $toBalance;
    public $toAccount;
    public $toSymbol;
    public $fromName;
    public $currency;
    public $balance;
    public $amount;
    public $symbol;
    public $toName;
    protected array $rules = [
        'amount' => 'required|string|integer',
        'toAccount' => 'required',
        'fromAccount' => 'required',
    ];

    public function rules()
    {
        return $this->rules;
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
        $flag = false;

        if (!$this->fromAccount || !$this->toAccount) {
            $this->dispatchBrowserEvent('message', [
                'text' => ' Select Transfer Accounts',
            ]);
        } elseif ($this->fromAccount == $this->toAccount) {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Select Different Accounts',
            ]);
        } else {
            $validatedData = $this->validate();

            $accountsArray = [$this->fromAccount, $this->toAccount];
            $accounts = Account::whereIn(
                'account_number',
                $accountsArray
            )->get();

            $count = count($accounts); // if count is less than 2. it means 1 or more account numbers are incorrect

            if ($count < 2) {
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Incorrect Accounts',
                ]);
            } else {
                foreach ($accounts as $accountToDebit) {
                    if ($accountToDebit->account_number == $this->fromAccount) {
                        if ($accountToDebit->account_balance >= $this->amount) {
                            $accountToDebit->account_balance -= $this->amount;
                            $accountToDebit->update();
                            $flag = true;
                            $this->fromBalance =
                                $accountToDebit->account_balance;
                            $this->dispatchBrowserEvent('message', [
                                'text' => 'Tranfer Completed',
                            ]);
                        } else {
                            $this->dispatchBrowserEvent('message', [
                                'text' => 'Insufficient Balance',
                            ]);
                        }
                    }
                }
                if ($flag == true) {
                    foreach ($accounts as $accounToCredit) {
                        if (
                            $accounToCredit->account_number == $this->toAccount
                        ) {
                            $accounToCredit->account_balance += $this->amount;
                            $accounToCredit->update();
                            $this->resetInput();
                            $this->toBalance = $accounToCredit->account_balance;
                        }
                    }
                }
            }
        }
    }

    public function fromAccount(): void
    {
        $activeAccounts = Account::where('user_id', Auth::id())
            ->where('account_number', $this->fromAccount)
            ->get();

        foreach ($activeAccounts as $activeAccount) {
            $this->fromBalance = $activeAccount->account_balance;
            $this->fromSymbol = $activeAccount->accounType->account_currency;
            $this->fromCurrency = $activeAccount->accounType->account_symbol;
            $this->fromName = $activeAccount->account_name;
        }
    }

    public function toAccount(): void
    {
        $activeAccounts = Account::where('user_id', Auth::id())
            ->where('account_number', $this->toAccount)
            ->get();

        foreach ($activeAccounts as $activeAccount) {
            $this->toBalance = $activeAccount->account_balance;
            $this->toSymbol = $activeAccount->accounType->account_currency;
            $this->toCurrency = $activeAccount->accounType->account_symbol;
            $this->toName = $activeAccount->account_name;
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

    public function resetInput()
    {
        $this->amount = null;
        
    }

    public function render()
    {
        $accounts = Account::where('user_id', Auth::id())->get();
        return view('livewire.operations', [
            'accounts' => $accounts,
        ]);
    }
}

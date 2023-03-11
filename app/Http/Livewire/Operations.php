<?php

namespace App\Http\Livewire;

use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Operations extends Component
{
    public $accountName;
    public $account_id;
    public $currency;
    public $balance;
    public $amount;

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

    public function getSelectedDepositAccount(): void
    {
        $activeAccounts = Account::where('user_id', Auth::id())
            ->where('id', $this->account_id)
            ->get();
        $this->loadData($activeAccounts);
    }

    public function getSelectedWithdrawalAccount()
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
                        $this->currency .
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
                                $this->currency .
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

    private function loadData($activeAccounts): void
    {
        foreach ($activeAccounts as $activeAccount) {
            $this->currency = $activeAccount->account_currency;
            $this->balance = $activeAccount->account_balance;
            $this->accountName = $activeAccount->account_name;
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

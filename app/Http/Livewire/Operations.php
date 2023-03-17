<?php

namespace App\Http\Livewire;

use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\TransactionRepository\TransactionRepository;

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
    public $result;
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
           // $validatedData = $this->validate();

            $accounts = Account::where('user_id', Auth::id())
                ->where('id', $this->account_id)
                ->get();

            if ($accounts) {
                foreach ($accounts as $account) {
                    $account->account_balance += $this->amount;
                    $account->update();
                    $this->balance = $account->account_balance;
                    $this->transaction($account->account_number, $this->currency, 'Deposit', 'Success',  'Deposit of ' .
                    $this->symbol .
                    $this->amount .
                    ' Successfull',  $account->user_id, $this->balance);
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


           // $validatedData = $this->validate();
           
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
                        $this->transaction($account->account_number, $this->currency, 'Withdrawal', 'Success',  'Withdrawal of ' .
                        $this->symbol .
                        $this->amount .
                        ' Successfull',  $account->user_id, $this->balance);
    
                        $this->resetInput();
                    } else {
                        $this->dispatchBrowserEvent('message', [
                            'text' => 'Insufficient Balance',
                        ]);
                        $this->transaction($account->account_number, $this->currency, 'Withdrawal', 'Failed', 'Insufficient Balance',  $account->user_id, $this->balance);
                        $this->resetInput();
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
        //dd($this->amount);
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
                //  dd($this->amount);
                foreach ($accounts as $accountToDebit) {
                    if ($accountToDebit->account_number == $this->fromAccount) {
                        if ($accountToDebit->account_balance >= $this->amount) {
                            $accountToDebit->account_balance -= $this->amount;
                            $accountToDebit->update();
                            $flag = true;
                            $this->fromBalance =
                                $accountToDebit->account_balance;
                            $this->dispatchBrowserEvent('message', [
                                'text' => 'Transfer Completed',
                            ]);
                            $this->transaction($accountToDebit->account_number, $this->fromCurrency, 'Transfer', 'Success',  
                            $this->fromSymbol.
                            $this->amount .
                            ' Transfer Debited',  $accountToDebit->user_id, $this->fromBalance);
                        } else {
                            $this->dispatchBrowserEvent('message', [
                                'text' => 'Insufficient Balance',
                            ]);
                            $this->transaction($accountToDebit->account_number,   $this->fromCurrency, 'Transfer', 'Failed',  'Insufficient Balance',  $accountToDebit->user_id,  $this->fromBalance);
                        }
                    }
                }
                if ($flag == true) {
                    foreach ($accounts as $accounToCredit) {
                        if ($accounToCredit->account_number == $this->toAccount) 
                            {
                                $accounToCredit->account_balance += $this->amount;
                                $accounToCredit->update();
                                $accounToCredit->user_id == Auth::id() ?
                                $this->toBalance = $accounToCredit->account_balance : '';
                                $this->transaction($accounToCredit->account_number,   $this->toCurrency, 'Transfer', 'Success', 
                                $this->toSymbol .
                                $this->amount .
                                ' Transfer Credited',  $accounToCredit->user_id,  $this->toBalance);
                                $this->resetInput();
                            }
                    }
                }
            }
        }
    }

    public function exchange()
    {
        if (!$this->fromCurrency || !$this->toCurrency) {
            $this->dispatchBrowserEvent('message', [
                'text' => ' Select Currencies',
            ]);
        } elseif ($this->fromAccount == $this->toAccount) {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Select Different Currencies',
            ]);
        } else {
            $validatedData = $this->validate();

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL =>
                    'https://api.apilayer.com/currency_data/convert?to=' .
                    $this->toCurrency .
                    '&from=' .
                    $this->fromCurrency .
                    '&amount=' .
                    $this->amount,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: text/plain',
                    'apikey: XByj6XjTvKFtHHsmUbJkyeat6Qfs8OtM',
                ],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ]);

            $response = curl_exec($curl);

            curl_close($curl);

            $result = json_decode($response, true);
            $this->result = $result['result'];
        }
    }


    private function transaction($account_number,  $currency, $operation, $status, $comment, $id, $balance)
    {
        $transaction_id = substr(str_shuffle('0123456789'), 0, 10);
        $createdAccountNumbers = TransactionRepository::getTransactionIDs();
        if (in_array($transaction_id, (array) $createdAccountNumbers)) {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Error with transaction_id',
            ]);
        } else {
            $data['id'] = $id;
            $data['account_number'] = $account_number;
            $data['transaction_id'] = $transaction_id;
            $data['operation'] = $operation;
            $data['status'] = $status;
            $data['currency'] = $currency;
            $data['description'] =
                'Lorem Ipsum is simply dummy text of  the';
            $data['comment'] = $comment;
            $data['amount'] = $this->amount;
            $data['balance'] = $balance;

            TransactionRepository::setTransactionData($data);
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

<?php

namespace App\Http\Livewire\TransactionRepository;

use App\Models\Transaction;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionRepository
{
    public static function setTransactionData($data): void
    {
        Transaction::create([
            'user_id' => $data['id'],
            'account_number' => $data['account_number'],
            'transaction_id' => $data['transaction_id'],
            'operation' => $data['operation'],
            'status' => $data['status'],
            'currency' => $data['currency'],
            'description' => $data['description'],
            'comment' => $data['comment'],
            'amount' => $data['amount'],
            'available_balance' => $data['balance'],
        ]);
    }

    public static function getTransactionIDs()
    {
        $transactionID = Transaction::all()->pluck('transaction_id');

        return $transactionID;
    }

    public function getTransactions(Request $request)
    {
        $input = $request->all();
        $account = $request->input('account_number');
        $timeFrame = [$request->input('start'), $request->input('end')];
        $array = ['account' => $account, 'period' => $timeFrame];

        $transactions = Transaction::where('user_id', Auth::id())

            ->when($array, function ($e2, $array) {
                $e2

                    ->when($array['account'], function ($e2, $account) {
                        $e2->Where('account_number', $account);
                    })
                    ->when(
                        in_array(null, $array['period'])
                            ? ''
                            : $array['period'],
                        function ($e2, $timeFrame) {
                            $e2->whereBetween('created_at', [
                                $timeFrame[0],
                                $timeFrame[1],
                            ]);
                        }
                    );
            })

            ->get();

        return $transactions;
    }
}

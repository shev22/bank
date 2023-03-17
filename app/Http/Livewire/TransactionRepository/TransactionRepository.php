<?php

namespace App\Http\Livewire\TransactionRepository;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionRepository
{
    public static function  setTransactionData($data): void
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
}

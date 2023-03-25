<?php

namespace App\Http\Livewire\TransactionRepository;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Query\Builder;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public static function saveNotifications($receiver_id, $message)
    {
        //dd($message);
        Notification::create([
            'transaction_sender_id' => Auth::id(),
            'transaction_receiver_id' => $receiver_id,
            'message' => $message,
        ]);
    }

    public function getNotifications()
    {
        $notifications = Notification::where(
            'transaction_receiver_id',
            Auth::id()
        )
        ->orderBy('created_at', 'DESC')
        ->get();
        $newMessage = $notifications->where('read_at' , 0)->all();
        return [
            'notifications'=>$notifications,
            'newMessage'=>  $newMessage
        ];
    }

    public function readNotification($request)
    {
        Notification::where(
            'transaction_receiver_id',
            Auth::id()
        )
            ->where('id', $request->id)
            ->update(['read_at' => 1]);
        $newMessage = Notification::where('transaction_receiver_id', Auth::id())->where('read_at', 0)->get();

        $content = $request->data;
        $notificationInfo = ['messages' => $content, 'newMessage' => $newMessage];
        echo json_encode($notificationInfo);
    }
    

    public function getTransactions(Request $request)
    {
        $input = $request->all();

      //  dump( $input);
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

            ->orderBy('created_at', 'DESC')
            ->get();

        return $transactions;
    }
}

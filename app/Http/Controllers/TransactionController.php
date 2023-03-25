<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Services\AccountService;
use App\Http\Controllers\Services\TransactionService;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    private $transactionService;
    private $accountService;

    public function __construct(
        TransactionService $transactionService,
        AccountService $accountService
    ) {
        $this->transactionService = $transactionService;
        $this->accountService = $accountService;
    }

    public function readNotification(Request $request)
    {
        $this->transactionService->readNotification($request);
    }

    // public function statement(Request $request)
    // {

    //     $transactions =   $this->transactionService->getTransactions($request);
    //     $total_transactions =  count( $transactions);
    //     $total =      $transactions->sum('amount');

    //     if( $total_transactions > 0 )
    //     {
    //         $data = ['transactions' =>  $transactions, 'request' => $request, 'total_transactions' => $total_transactions, 'total' => $total];
    //         $pdf = Pdf::loadView('frontend.statement', $data)->setPaper('a4', 'landscape');
    //         return $pdf->stream('statement '.Auth::user()->name.'.pdf');
    //     }else{
    //         Session::flash('message', 'No transactions match the provided data');
    //         Session::flash('alert-class', 'alert-danger');
    //         return redirect()->route('transactions');
    //     }

    // }

    public function viewStatement(Request $request)
    {
        $transactions = $this->transactionService->getTransactions($request);
        $total_transactions = count($transactions);
        $total = $transactions->sum('amount');
        return view('frontend.statement', [
            'transactions' => $transactions,
            'request' => $request,
            'total_transactions' => $total_transactions,
            'total' => $total,
        ]);
    }

    public function index(Request $request)
    {
        $accounts = $this->accountService->getUserAccounts();
        $transactions = $this->transactionService->getTransactions($request);
        $notifications = $this->transactionService->getNotifications();
        $total_transactions = count($transactions);
        $total = $transactions->sum('amount');

        if ($request->has('download-statement')) {
            if ($total_transactions > 0) {
                $data = [
                    'transactions' => $transactions,
                    'request' => $request,
                    'total_transactions' => $total_transactions,
                    'total' => $total,
                ];
                $pdf = Pdf::loadView('frontend.statement', $data)->setPaper(
                    'a4',
                    'landscape'
                );
                return $pdf->stream('statement ' . Auth::user()->name . '.pdf');
            } else {
                Session::flash(
                    'message',
                    'No transactions match the provided data'
                );
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('transactions');
            }
        }

        return view('frontend.transaction', [
            'transactions' => $transactions,
            'accounts' => $accounts,
            'notifications' => $notifications['notifications'],
            'newMessage' => $notifications['newMessage'],
        ]);
    }
}

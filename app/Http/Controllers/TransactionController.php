<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Services\AdminService;
use App\Http\Controllers\Services\AccountService;
use App\Http\Controllers\Services\TransactionService;

class TransactionController extends Controller
{
    private $transactionService;
    private $accountService;
    private $adminService;

    public function __construct(
        TransactionService $transactionService,
        AccountService $accountService,
        AdminService $adminService
    ) {
        $this->transactionService = $transactionService;
        $this->accountService = $accountService;
        $this->adminService = $adminService;
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

    public function emailStatement($pdf, $data)
    {          
        Mail::send('frontend.statement', $data, function (
            $message
        ) use ($pdf) {
            $message
                ->to(Auth::user()->email)
                ->subject(
                    'Bank Statement for ' . Auth::user()->name
                )
                ->attachData($pdf->output(), 'Statement.pdf');
        });
        Session::flash('message', 'Email Sent Successfully');
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('transactions');
    }


    public function index(Request $request)
    {
        $accounts = $this->accountService->getUserAccounts();
        $accountsTypes = $this->accountService->getAccountCurrencies();
        $transactions = $this->transactionService->getTransactions($request);
        $notifications = $this->transactionService->getNotifications();
        $total_transactions = count($transactions);
        $currencies = $this->adminService->currencyAPI();
        $total = $transactions->sum('amount');

        if (
            $request->has('download-statement') ||
            $request->has('email-statement')
        ) {
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
                if ($request->has('email-statement')) {
               
                    $this->emailStatement($pdf, $data);
                } else {
                    return $pdf->stream(
                        'statement ' . Auth::user()->name . 'statement.pdf'
                    );
                }
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
            'accounts' => $accounts,
            'currencies' => $currencies,
            'transactions' => $transactions,
            'accounts_types' => $accountsTypes,   
            'notifications' => $notifications['notifications'],
            'newMessage' => $notifications['newMessage'],
        ]);
    }
}

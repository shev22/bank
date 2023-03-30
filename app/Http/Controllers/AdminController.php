<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Services\AccountService;
use App\Http\Controllers\Services\TransactionService;

class AdminController extends Controller
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





















    public function index()
    {
        $notifications = $this->transactionService->getNotifications();
        return view('frontend.admin', [
            'notifications' => $notifications['notifications'],
            'newMessage' => $notifications['newMessage'],
        ]);
    }
}

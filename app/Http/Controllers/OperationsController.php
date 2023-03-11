<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Services\AccountService;

class OperationsController extends Controller
{
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index()
    {
        $accountsTypes = $this->accountService->getAccountCurrencies();
        return view('frontend.operations', [
            'accounts_types' => $accountsTypes,
        ]);
    }
}

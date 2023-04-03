<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Services\AccountService;


class AccountController extends Controller
{
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function createAccount(Request $request)
    {

        $validatedData = $request->validate([
           'account_name' => 'required|max:255',
           'account_currency' => 'required',
            
        ]);
        $this->accountService->createAccount($request);
        return redirect()->route('dashboard');
    }


    public function getAccountDetail(Request $request)
    {
        $this->accountService->getAccountDetail($request);                
    }

    }


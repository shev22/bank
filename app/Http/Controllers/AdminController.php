<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Services\AdminService;
use App\Http\Controllers\Services\AccountService;
use App\Http\Controllers\Services\TransactionService;

class AdminController extends Controller
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

    public function role(Request $request)
    {
        $this->adminService->role($request);
        return redirect()->back();
    }

    public function edit(Request $request)
    {
        $this->adminService->edit($request);
    }

    public function update(Request $request)
    {

        $this->adminService->update($request);
        return redirect()->route('admin');
    }

    public function delete(Request $request)
    {
        $this->adminService->delete($request);
        return redirect()->route('admin');
    }

    public function currencyAPI()
    {
      return($this->adminService->currencyAPI());
    }

    
    public function operations(Request $request)
    {
      return($this->adminService->operations($request));
    }

    public function index()
    {
        $currencies = $this->currencyAPI();
       // dd( $currencies);
        $accountsTypes = $this->accountService->getAccountCurrencies();
        $users = $this->adminService->getUsers();
        $notifications = $this->transactionService->getNotifications();
        return view('frontend.admin', [
            'users' => $users,
            'currencies' => $currencies,
            'accounts_types' => $accountsTypes, 
            'notifications' => $notifications['notifications'],
            'newMessage' => $notifications['newMessage'],
        ]);
    }
}

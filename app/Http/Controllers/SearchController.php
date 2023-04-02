<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Services\SearchService;
use App\Http\Controllers\Services\AdminService;
use App\Http\Controllers\Services\AccountService;
use App\Http\Controllers\Services\TransactionService;

class SearchController extends Controller
{
    private $transactionService;
    private $searchService;
    private $accountService;
    private $adminService;

    public function __construct(
        TransactionService $transactionService,
        SearchService $searchService,
        AccountService $accountService,
        AdminService $adminService
    ) {
        $this->transactionService = $transactionService;
        $this->searchService = $searchService;
        $this->accountService = $accountService;
        $this->adminService = $adminService;
    }

    public function search($request)
    {
        $request->validate([
            'search' => 'required|max:255',
        ]);
        $results = $this->searchService->search($request);
        return $results;
    }

    public function index(Request $request)
    {
        $accountsTypes = $this->accountService->getAccountCurrencies();
        $currencies = $this->adminService->currencyAPI();
        $search = $this->search($request);
        $searchTitle = $this->searchService-> setHeader($search);
        $notifications = $this->transactionService->getNotifications();
        return view('frontend.search', [
            'search' => $search,
            'accounts_types' => $accountsTypes, 
            'currencies' => $currencies,
            'searchTitle' => $searchTitle,
            'notifications' => $notifications['notifications'],
            'newMessage' => $notifications['newMessage'],
            
        ]);
    }
}

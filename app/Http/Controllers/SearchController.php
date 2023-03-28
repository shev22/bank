<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\SearchService;
use Illuminate\Http\Request;
use App\Http\Controllers\Services\TransactionService;

class SearchController extends Controller
{
    private $transactionService;
    private $searchService;

    public function __construct(
        TransactionService $transactionService,
        SearchService $searchService
    ) {
        $this->transactionService = $transactionService;
        $this->searchService = $searchService;
    }

    public function search($request)
    {
        $results = $this->searchService->search($request);
        return $results;
    }

    public function index(Request $request)
    {
        $search = $this->search($request);
        $searchTitle = $this->searchService-> setHeader($search);
        $notifications = $this->transactionService->getNotifications();
        return view('frontend.search', [
            'search' => $search,
            'searchTitle' => $searchTitle,
            'notifications' => $notifications['notifications'],
            'newMessage' => $notifications['newMessage'],
            
        ]);
    }
}

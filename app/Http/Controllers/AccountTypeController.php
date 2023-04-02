<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\AdminService;
use Illuminate\Http\Request;

class AccountTypeController extends Controller
{

    private $adminService;

    public function __construct(AdminService $adminService) {
    
        $this->adminService = $adminService;
    }













    public function currency(Request $request) // add currency to db afrom currencyAPI
    {
        $this->adminService->addCurrency($request);
        return redirect()->route('admin');
        
    }
}

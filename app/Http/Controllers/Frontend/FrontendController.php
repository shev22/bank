<?php

namespace App\Http\Controllers\Frontend;

use view;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{

    public const DASHBOARD = '/dashboard';











    public function dashboard()
    {
        return view('frontend.dashboard');
    }


   
}

<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return redirect()->route('user_profile');
//        return view('dashboard');
    }
}

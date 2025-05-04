<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Retrieve the authenticated account details
        // $account = Auth::user();
        // Return the home view with the account details
        return view('layouts.home');
    }
}

?>
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // Get the authenticated user details
        $account = Auth::user();

        // Return the profile view with the authenticated user details
        return view('layouts.profile', ['account' => $account]);
    }
}

?>

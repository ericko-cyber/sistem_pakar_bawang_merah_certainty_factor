<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function index()
    {
        return view('layouts.admin.masteradmin'); // file: resources/views/homeadmin.blade.php
    }
}

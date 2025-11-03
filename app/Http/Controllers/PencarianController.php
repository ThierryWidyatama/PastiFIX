<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PencarianController extends Controller
{
    public function index(Request $request)
    {
        return view('visitor.welcome');
    }
}

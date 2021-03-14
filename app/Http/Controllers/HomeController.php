<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __invoke()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('login');
    }
}

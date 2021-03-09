<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class SignOutController extends Controller
{
    public function __invoke()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

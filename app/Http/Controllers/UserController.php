<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function sign_out()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

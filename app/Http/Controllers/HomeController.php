<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    public function __invoke()
    {
        ini_set('session.cookie_domain', 'herokuapp.com');
        Cookie::queue('test1', 'x', 60*24*90, $domain='.herokuapp.com');
        Cookie::queue('test2', 'x', 60*24*90, $domain='herokuapp.com');
        Cookie::queue('test3', 'x', 60*24*90, $domain='.herokuapp.com');
        Cookie::queue('test4', 'x', 60*24*90, $domain='herokuapp.com');
        setcookie('test5','x', 60*24*90, $domain='herokuapp.com');
        setcookie('test6','x', 60*24*90, $domain='herokuapp.com');

        
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('login');
    }
}

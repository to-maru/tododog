<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TermsController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = null;
        if (Auth::check()) {
            $user = $request->user();
        }
        return view('terms', [
            'user' => $user
        ]);
    }
}

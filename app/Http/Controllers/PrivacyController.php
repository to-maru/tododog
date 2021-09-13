<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivacyController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = null;
        if (Auth::check()) {
            $user = $request->user();
        }
        return view('privacy', [
            'user' => $user
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Analyser;
use App\Models\TodoApplication;
use App\Models\User;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SignOutController extends Controller
{
    public function __invoke()
    {
        Auth::logout();
        return redirect(route('login'));
    }
}

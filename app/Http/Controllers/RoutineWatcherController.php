<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoutineWatcherController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $analyser = $user->analyser;
        return view('routine_watcher', [
//            'user' => $user,
            'analyser' => $analyser,
        ]);
    }
}

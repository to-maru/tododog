<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoutineWatcherController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $routine_watcher_setting = $user->routine_watcher_setting;
        return view('routine_watcher', [
            'user' => $user,
            'setting' => $routine_watcher_setting,
        ]);
    }
}

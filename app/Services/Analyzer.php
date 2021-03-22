<?php


namespace App\Services;


use App\Models\Todo;
use App\Models\User;

class Analyzer
{
    public function analyze(User $user)
    {
        $routine_watcher_setting = $user->routine_watcher_setting;
        $arr = [];
        $project_id = $routine_watcher_setting->project_id;
        if ($project_id !== NULL) {
            $arr[] = ['project_name', '=', $project_id];
        }

        $todos = Todo::where($arr)->count();
    }
}

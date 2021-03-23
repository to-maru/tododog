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
        $tag_ids = $routine_watcher_setting->tag_ids;
        info(json_decode($tag_ids, true));
        if ($project_id !== NULL) {
            $arr[] = ['project_id', '=', $project_id];
        }

//        if (count($tag_ids) > 0) {
//            $arr[] = ['tag_ids'];
//        }

        $todos = Todo::where($arr)->count();
    }
}

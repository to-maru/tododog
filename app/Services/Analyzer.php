<?php


namespace App\Services;


use App\Models\Todo;
use App\Models\User;

class Analyzer
{
    public function analyze(User $user)
    {
        $routine_watcher_setting = $user->routine_watcher_setting;
        $project_id = $routine_watcher_setting->project_id;
        $tag_ids = json_decode($routine_watcher_setting->tag_ids, true);
        $todos = new Todo;
        if ($project_id == NULL) {
            $todos = $todos::all();
            $arr[] = ['project_id', '=', $project_id];
        } else {
            $todos = $todos::where('project_id', $project_id)->get();
        }

        if ($tag_ids !== NULL) {
            $todos->filter(function ($todo) use ($tag_ids) {
                $todo_tag_ids = json_decode($todo->tag_ids, true);
                return count(array_intersect($todo_tag_ids, $tag_ids)) > 0;
            });
        }

        info($todos);
    }
}

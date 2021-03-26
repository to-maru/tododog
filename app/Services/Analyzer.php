<?php


namespace App\Services;


use App\Models\Todo;
use App\Models\TodoDoneDatetime;
use App\Models\User;

class Analyzer
{
    public function analyze(User $user)
    {
        $routine_watcher_setting = $user->routine_watcher_setting;
        $project_id = $routine_watcher_setting->project_id;
        $tag_ids = json_decode($routine_watcher_setting->tag_ids, true);
        $todos = new Todo;
        $todos = $this->filterTodosByProjectId($todos, $project_id);
        $todos = $this->filterTodosByTagIds($todos, $tag_ids);

        $results = array();
        $todos->each(function ($todo) use (&$results) {
            info($todo->id);
            $results[$todo->id] = $this->analyzeTodo($todo);
        });
        info($results);

    }

    public function analyzeTodo($todo)
    {
        $done_datetimes = TodoDoneDatetime::where('todo_id', $todo->id)->get();
        $result = array();
        $result['running_days'] = 0;
        $result['days_in_66days'] = 0;
        $result['times_in_66days'] = 0;
        $result['total_times'] = $done_datetimes->count();
        return $result;
    }

    public function filterTodosByProjectId($todos, $project_id)
    {
        if ($project_id == NULL) {
            return $todos::all();
        } else {
            return $todos::where('project_id', $project_id)->get();
        }
    }

    public function filterTodosByTagIds($todos, $tag_ids)
    {
        if ($tag_ids !== NULL) {
            return $todos->filter(function ($todo) use ($tag_ids) {
                $todo_tag_ids = json_decode($todo->tag_ids, true);
                return count(array_intersect($todo_tag_ids, $tag_ids)) > 0;
            });
        }
        return $todos;
    }
}

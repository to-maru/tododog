<?php


namespace App\Services;


use App\Models\Todo;
use App\Models\TodoDoneDatetime;
use App\Models\User;
use Carbon\Carbon;

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
            $results[$todo->id] = $this->analyzeTodo($todo);
        });
        info($results);

    }

    public function analyzeTodo($todo)
    {
        $done_datetimes = TodoDoneDatetime::where('todo_id', $todo->id)->orderBy('done_datetime', 'desc')->get();
        $result = array();
        $result['running_days'] = $this->countRunningDays($done_datetimes);
        $result['foot_prints'] = $this->countFootPrints($done_datetimes);
        $result['total_times'] = $this->countTotalTimes($done_datetimes);
        return $result;
    }

    public function countRunningDays($done_datetimes)
    {
        return $done_datetimes->count();
    }

    public function countFootPrints($done_datetimes)
    {
        $foot_prints = "";
        $number_of_days = 7;
        $ok_char = 'o';
        $ng_char = 'x';
        $start_date = Carbon::yesterday();
        $end_date = Carbon::today();
        for ($i = 0; $i < $number_of_days; $i++) {
            $done_of_the_day = $done_datetimes->first(function ($done_datetime) use ($start_date, $end_date) {
                $dt = $done_datetime->done_datetime;
                return $dt->gte($start_date) and $dt->lt($end_date);
            });

            if (isset($done_of_the_day)) {
                $foot_prints = $foot_prints . $ok_char;
            } else {
                $foot_prints = $foot_prints . $ng_char;
            }
            $start_date->subDay();
            $end_date->subDay();
        }
        return $foot_prints;
    }

    public function countTotalTimes($done_datetimes)
    {
        return $done_datetimes->count();
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

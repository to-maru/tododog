<?php


namespace App\Services;


use App\Models\Todo;
use App\Models\TodoDoneDatetime;
use App\Models\User;
use Carbon\Carbon;

class Analyzer
{
    private $setting;

    public function analyze(User $user)
    {
        $this->setting = $user->user_setting_analysis;
        $project_id = $this->setting->project_id;
        $tag_ids = json_decode($this->setting->tag_ids, true);
        $todos = Todo::where('todo_application_id', $user->todo_application->id)->get();
        $todos = $this->filterTodosByProjectId($todos, $project_id);
        $todos = $this->filterTodosByTagIds($todos, $tag_ids);

        $results = array();
        $todos->each(function ($todo) use (&$results) {
            $results[$todo->id] = $this->analyzeTodo($todo);
        });
        return $results;

    }

    public function analyzeTodo($todo)
    {
        $done_datetimes = TodoDoneDatetime::where('todo_id', $todo->id)->orderBy('done_datetime', 'desc')->get();
        $result = array();
        $result['running_days'] = $this->calculateRunningDays($done_datetimes);
        $result['sleeping_days'] = $this->calculateSleepingDays($done_datetimes);
        $result['foot_prints'] = $this->makeFootPrints($done_datetimes);
        $result['total_times'] = $this->getTotalTimes($done_datetimes);
        $result['achievements'] = $this->makeAchievements($result);
        return $result;
    }

    public function calculateRunningDays($done_datetimes)
    {
        $cheat_day_enabled = $this->setting->cheat_day_enabled;
        $cheat_day_interval = $this->setting->cheat_day_interval;

        $running_days = 0;
        $days_to_cheat_day = 0;
        $date = Carbon::yesterday();

        while (true) {
            if ($this->existsDoneDatetime($done_datetimes, $date)) {
                $days_to_cheat_day--;
            } else {
                if (!$cheat_day_enabled or $days_to_cheat_day > 0) {
                    if ($cheat_day_enabled and $running_days === 1) {
                        return 0;
                    }
                    return $running_days;
                }
                $days_to_cheat_day = $cheat_day_interval;
            }
            $running_days++;
            $date = $date->subDay();
        }
    }

    public function calculateSleepingDays($done_datetimes)
    {
        if (is_null($done_datetimes->first())) {
            return null;
        }
        return Carbon::today()->diffInDays($done_datetimes->first()->done_datetime);
    }

    public function makeFootPrints($done_datetimes)
    {
        $number_of_days = $this->setting->footprints_number;
        $ok_char = 'o';
        $ng_char = 'x';

        $foot_prints = "";
        $date = Carbon::yesterday();
        for ($i = 0; $i < $number_of_days; $i++) {
            if ($this->existsDoneDatetime($done_datetimes, $date)) {
                $foot_prints = $foot_prints . $ok_char;
            } else {
                $foot_prints = $foot_prints . $ng_char;
            }
            $date = $date->subDay();
        }
        return $foot_prints;
    }

    public function getTotalTimes($done_datetimes)
    {
        return $done_datetimes->count();
    }

    public function makeAchievements(array $result)
    {
        return '';
    }

    public function existsDoneDatetime($done_datetimes, Carbon $date)
    {
        $next_date = $date->copy()->addDay();
        $done_of_the_day = $done_datetimes->first(function ($done_datetime) use ($date, $next_date) {
            $dt = $done_datetime->done_datetime;
            return $dt->gte($date) and $dt->lt($next_date);
        });
        return isset($done_of_the_day);
    }

    public function filterTodosByProjectId($todos, $project_id)
    {
        if ($project_id !== NULL) {
            return $todos->filter(function ($todo) use ($project_id) {
                return $todo->project_id == $project_id;
            });
        }
        return $todos;
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

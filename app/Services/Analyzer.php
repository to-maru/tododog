<?php


namespace App\Services;


use App\Models\Todo;
use App\Models\TodoDoneDatetime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Analyzer
{
    private $setting;

    public function analyze(User $user)
    {
        $this->setting = $user->user_setting_analysis;
        $project_id = $this->setting->project_id;
        $tag_ids = json_decode($this->setting->tag_ids, true);
        $todos = $user->todo_application->todos;
        $todos = $this->filterTodosByProjectId($todos, $project_id);
        $todos = $this->filterTodosByTagIds($todos, $tag_ids);

        $todo_results = array();
        $todos->each(function ($todo) use (&$todo_results) {
            $todo_results[$todo->id]['todo'] = $todo;
            $todo_results[$todo->id]['result'] = $this->analyzeTodo($todo);
        });
        return $todo_results;

    }

    public function analyzeTodo(Todo $todo)
    {
        $done_datetimes = $todo->done_datetimes->sortByDesc('done_datetime');
        if ($this->setting->time_offset_enabled) {
            $done_datetimes = $done_datetimes->map(function (Carbon $datetime) {
                return $datetime->subHours(4);
            });
        }
        $result = array();
        $result['running_days'] = $this->calculateRunningDays($done_datetimes);
        $result['sleeping_days'] = $this->calculateSleepingDays($done_datetimes);
        $result['foot_prints'] = $this->makeFootPrints($done_datetimes, $todo->origin_created_at);
        $result['total_times'] = $this->getTotalTimes($done_datetimes);
        $result['max_monthly_times'] = $this->calculateMaxMonthlyTimes($done_datetimes);
        $result['this_month_times'] = $this->calculateTimesThisMonth($done_datetimes);
        return $result;
    }

    public function calculateRunningDays(Collection $done_datetimes)
    {
        $cheat_day_enabled = $this->setting->cheat_day_enabled;
        $cheat_day_interval = $this->setting->cheat_day_interval;

        $running_days = 0;
        $days_to_cheat_day = 0;
        $should_remove_cheat_day = false;
        $date = Carbon::yesterday();

        while (true) {
            if ($this->existsDoneDatetime($done_datetimes, $date)) {
                $days_to_cheat_day--;
                $should_remove_cheat_day = false;
            } else {
                if (!$cheat_day_enabled or $days_to_cheat_day > 0) {
                    $offset_days = $should_remove_cheat_day ? -1 : 0;
                    return $running_days + $offset_days;
                }
                $days_to_cheat_day = $cheat_day_interval;
                $should_remove_cheat_day = true;
            }
            $running_days++;
            $date = $date->subDay();
        }
    }

    public function calculateSleepingDays(Collection $done_datetimes)
    {
        if (is_null($done_datetimes->first())) {
            return null;
        }
        return Carbon::today()->diffInDays($done_datetimes->first()->done_datetime);
    }

    public function makeFootPrints(Collection $done_datetimes, Carbon $origin_created_at)
    {
        $number_of_days = $this->setting->footprints_number;
        $ok_char = 'o';
        $ng_char = 'x';

        $foot_prints = "";
        $date = Carbon::yesterday();
        for ($i = 0; $i < $number_of_days; $i++) {
            if ($date->lt($origin_created_at) && !$date->isSameDay($origin_created_at)) {
                break;
            }
            if ($this->existsDoneDatetime($done_datetimes, $date)) {
                $foot_prints = $foot_prints . $ok_char;
            } else {
                $foot_prints = $foot_prints . $ng_char;
            }
            $date = $date->subDay();
        }
        return $foot_prints;
    }

    public function calculateTimesThisMonth(Collection $done_datetimes)
    {
        return $done_datetimes
            ->filter(function (TodoDoneDatetime $done_datetime) {
                return $done_datetime->done_datetime->isCurrentMonth();
            })
            ->count();
    }

    public function calculateMaxMonthlyTimes(Collection $done_datetimes)
    {
        return $done_datetimes->countBy(function (TodoDoneDatetime $done_datetime) {
            return $done_datetime->done_datetime->year . $done_datetime->done_datetime->month;
        })->max();
    }

    public function getTotalTimes(Collection $done_datetimes)
    {
        return $done_datetimes->count();
    }

    public function existsDoneDatetime(Collection $done_datetimes, Carbon $date)
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

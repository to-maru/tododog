<?php

namespace App\Jobs;

use Carbon\Carbon;
use Carbon\Exceptions\RuntimeException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class GetEventsFromItem implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $object_id = 3725455823; //DailyPlanning
    const OBJECT_TYPE = 'item';
    const EVENT_TYPE = 'completed';
    const DAY_START_HOUR = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        Carbon::setTestNow(Carbon::today()->subMonth(4));
        $events_arr = [];
        for ($i = 0; $i <= 20; $i++) {
            $events_arr = array_merge($events_arr, $this->getEventsFromPage($i));
        }
        $all_events = array_merge($events_arr);
        $events_dates = $this->getDatesOfEvents($all_events);

        echo(json_encode($all_events, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        echo(json_encode($events_dates, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        echo('running:' . $this->getRunningDays($events_dates));
        echo("\n" . 'latest:' . $this->getLatestDate($events_dates));
        echo(Carbon::today()->subMonth(4));
        echo("\n" . 'count:' . $this->countDays($events_dates, Carbon::today()->subMonth(4)));
    }

    private function getEventsFromPage(int $page)
    {
        $response = Http::asForm()->post('https://api.todoist.com/sync/v8/activity/get', [
            'token' => config('todoapp.todoist.api_key'),
            'limit' => 100,
            'object_type' => self::OBJECT_TYPE,
            'object_id' => $this->object_id,
            'event_type' => self::EVENT_TYPE,
            'page' => $page,
        ]);
        info(json_decode($response->body(), true)['count']);
        return json_decode($response->body(), true)['events'];
    }

    private function getDateTimesOfEvents(array $events)
    {
        return array_column($events, 'event_date');
    }

    private function getDatesOfEvents(array $events)
    {
        return array_map(function ($event) {
            $datetime_format = function (string $datetime) {
                return Carbon::parse($datetime)->subHour(self::DAY_START_HOUR);
            };
            return $datetime_format($event['event_date']);
        }, $events);
    }

    public function countDays(array $dates, Carbon $start_date): int
    {
        $tmp_date = Carbon::today();
        $count = 0;

        if ($start_date->gt($tmp_date)) {
            throw new \RuntimeException("集計期間が無効です。");
        }

        while ($tmp_date->gt($start_date) || $tmp_date->isSameDay($start_date)) {
            if ($this->existsSameDayInArray($tmp_date, $dates)) {
                $count++;
            }
            $tmp_date->subDay();
        }

        return $count;
    }

    public function getRunningDays(array $dates): int
    {
        $tmp_date = Carbon::today();
        $running_days = 0;

        while ($this->existsSameDayInArray($tmp_date, $dates)) {
            $running_days++;
            $tmp_date->subDay();
        }
        return $running_days;
    }

    public function getLatestDate(array $dates): Carbon
    {
        $latest_date = Carbon::today();

        while (!$this->existsSameDayInArray($latest_date, $dates)) {
            $latest_date->subDay();
        }
        return $latest_date;
    }

    public function existsSameDayInArray(Carbon $needle, array $haystack): bool
    {
        foreach ($haystack as $hay) {
            if ($hay->isSameday($needle)) {
                return true;
            }
        }

        return false;
    }
}

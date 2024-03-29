<?php


namespace App\Services;


use App\Models\Todo;
use App\Models\TodoApplication;
use App\Models\TodoDoneDatetime;
use App\Traits\TodoApplicationApiClientTrait;
use Carbon\Carbon;

class Synchronizer
{
    use TodoApplicationApiClientTrait;
    public $api_client;

    public function __construct()
    {

    }

    public function pullTodosAndDonetimes(TodoApplication $todo_application)
    {
        $raw_todos = $this->fetchAllTodos($this->api_client);
        foreach ($raw_todos as $raw_todo) {
            $origin_created_at_tz = Carbon::parse($raw_todo['date_added'])->addHours(9)->toDateTimeString() . '+09';
            Todo::updateOrCreate(
                ['todo_application_id' => $todo_application->id, 'local_id' => $raw_todo['id']],
                ['name' => $raw_todo['content'], 'origin_created_at' => $origin_created_at_tz, 'project_id' => $raw_todo['project_id'], 'tag_ids' => json_encode($raw_todo['labels']), 'raw_data' => json_encode($raw_todo)]
            ); //todo:各todo_appで共通化したい 'name' => $todo['name']的な
        }

        $raw_todo_done_datetimes = $this->fetchAllTodoDonetimes($this->api_client);
        foreach ($raw_todo_done_datetimes as $raw_todo_done_datetime) {
            $todo = $todo_application->todos->firstwhere('local_id', $raw_todo_done_datetime['object_id']);
            $done_datetime_tz = Carbon::parse($raw_todo_done_datetime['event_date'])->addHours(9)->toDateTimeString() . '+09';
            if (!is_null($todo)) {
                TodoDoneDatetime::firstOrCreate([
                    'todo_id' => $todo->id,
                    'done_datetime' => $done_datetime_tz
                ]);
            }
        }
        $todo_application->synced_at = Carbon::now();
        $todo_application->save();
    }
}

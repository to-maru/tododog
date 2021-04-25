<?php


namespace App\Services;


use App\Models\Todo;
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

    public function pullTodosAndDonetimes($todo_application)
    {
        $todos = $this->fetchAllTodos($this->api_client);
        foreach ($todos as $todo) {
            Todo::updateOrCreate(
                ['todo_application_id' => $todo_application->id, 'local_id' => $todo['id']],
                ['name' => $todo['content'], 'origin_created_at' => $todo['date_added'], 'project_id' => $todo['project_id'], 'tag_ids' => json_encode($todo['labels']), 'raw_data' => json_encode($todo)]
            ); //todo:各todo_appで共通化したい 'name' => $todo['name']的な
        }

        $todo_done_datetimes = $this->fetchAllTodoDonetimes($this->api_client);
        foreach ($todo_done_datetimes as $todo_done_datetime) {
            $todo = Todo::firstwhere('local_id',$todo_done_datetime['object_id']);
            if (!is_null($todo)) {
                TodoDoneDatetime::firstOrCreate(
                    ['todo_id' => $todo->id, 'done_datetime' => $todo_done_datetime['event_date']]
                );
            }
        }
        $todo_application->synced_at = Carbon::now();
        $todo_application->save();
    }
}

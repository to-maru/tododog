<?php


namespace App\Services;


use App\Models\Todo;
use App\Traits\TodoApplicationApiClientTrait;

class Synchronizer
{
    use TodoApplicationApiClientTrait;
    public $api_client;

    public function __construct()
    {

    }

    public function syncronizeTodo($todo_application)
    {
        $todos = $this->getAllTodos($this->api_client);
        foreach ($todos as $todo) {
            Todo::updateOrCreate(
                ['todo_application_id' => $todo_application->id, 'local_id' => $todo['id']],
                ['name' => $todo['content'], 'origin_created_at' => $todo['date_added'], 'project_name' => $todo['project_id'], 'raw_data' => json_encode($todo)]
            ); //todo:各todo_appで共通化したい 'name' => $todo['name']的な
        }
        $todo_done_datetimes = $this->getAllTodoDonetimes($this->api_client);
    }
}

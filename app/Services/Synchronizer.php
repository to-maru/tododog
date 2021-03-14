<?php


namespace App\Services;


use App\Models\Todo;
use App\Models\TodoApplication;
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
        $todos = $this->getAllTodoNames($this->api_client);
        foreach ($todos as $key => $value) {
            Todo::updateOrCreate(
                ['todo_application_id' => $todo_application->id, 'local_id' => $key],
                ['name' => $value]
            );
        }
    }
}

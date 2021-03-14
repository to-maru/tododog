<?php


namespace App\Services;


use App\Models\TodoApplication;
use App\Traits\TodoApplicationApiClientTrait;

class TodoApplicationSynchronizer
{
    use TodoApplicationApiClientTrait;
    public $api_client;

    public function __construct()
    {

    }

    public function setApiClient(TodoApplication $todo_application)
    {
        $this->api_client = new TodoistApiClient($todo_application->access_token);
    }

    public function syncronizeTodo()
    {
        info($this->api_client->getAllTodos());
    }



}

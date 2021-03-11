<?php


namespace App\Services;


use App\Models\TodoApplication;

class TodoApplicationSynchronizer
{
    public function __construct(public TodoApplicationApiClientInterface $api_client){

    }

    public function syncronizeTodo(TodoApplication $todo_application)
    {
        $this->setApiClient($todo_application);
    }

    public function setApiClient(TodoApplication $todo_application)
    {
        $this->api_client = new TodoistApiClient($todo_application->access_token);
    }
}

<?php


namespace App\Services;


use App\Models\TodoApplication;

class TodoApplicationSynchronizer
{
    /**
     * TodoApplicationSynchronizer constructor.
     * @param TodoApplicationApiClientInterface $api_client
     */
    public function __construct(public TodoApplicationApiClientInterface $api_client)
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

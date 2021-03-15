<?php


namespace App\Traits;

use App\Models\TodoApplication;
use App\Services\TodoApplicationApiClientInterface;
use App\Services\TodoistApiClient;

trait TodoApplicationApiClientTrait
{

    public function getApiClient(TodoApplication $todo_application)
    {
        return new TodoistApiClient($todo_application->access_token, $todo_application);
    }

    public function getAllProjects(TodoApplicationApiClientInterface $api_client)
    {
        return $api_client->getAllProjects();
    }

    public function getAllProjectNames(TodoApplicationApiClientInterface $api_client)
    {
        return $api_client->getAllProjectNames();
    }

    public function getAllTagNames(TodoApplicationApiClientInterface $api_client)
    {
        return $api_client->getAllTagNames();
    }

    public function getAllTags(TodoApplicationApiClientInterface $api_client)
    {
        return $api_client->getAllTags();
    }

    public function getAllTodos(TodoApplicationApiClientInterface $api_client)
    {
        return $api_client->getAllTodos();
    }

    public function getAllTodoNames(TodoApplicationApiClientInterface $api_client)
    {
        return $api_client->getAllTodoNames();
    }

    public function getAllTodoDonetimes(TodoApplicationApiClientInterface $api_client)
    {
        return $api_client->getAllTodoDonetimes();
    }
}

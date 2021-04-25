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

    public function fetchAllProjects(TodoApplicationApiClientInterface $api_client)
    {
        return $api_client->fetchAllProjects();
    }

    public function fetchAllProjectNames(TodoApplicationApiClientInterface $api_client)
    {
        return $api_client->fetchAllProjectNames();
    }

    public function fetchAllTagNames(TodoApplicationApiClientInterface $api_client)
    {
        return $api_client->fetchAllTagNames();
    }

    public function fetchAllTags(TodoApplicationApiClientInterface $api_client)
    {
        return $api_client->fetchAllTags();
    }

    public function pushNewTag(TodoApplicationApiClientInterface $api_client, string $name)
    {
        return $api_client->pushNewTag($name);
    }

    public function pushDeletedTags(TodoApplicationApiClientInterface $api_client, array $ids)
    {
        return $api_client->pushDeletedTags($ids);
    }

    public function fetchAllTodos(TodoApplicationApiClientInterface $api_client)
    {
        return $api_client->fetchAllTodos();
    }

    public function fetchAllTodoNames(TodoApplicationApiClientInterface $api_client)
    {
        return $api_client->fetchAllTodoNames();
    }

    public function fetchAllTodoDonetimes(TodoApplicationApiClientInterface $api_client)
    {
        return $api_client->fetchAllTodoDonetimes();
    }

    public function pushTodos(TodoApplicationApiClientInterface $api_client, array $todo_update_orders)
    {
        return $api_client->pushTodos($todo_update_orders);
    }
}

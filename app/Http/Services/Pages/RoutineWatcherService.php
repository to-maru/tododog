<?php


namespace App\Http\Services\Pages;


use App\Http\Services\TodoApplicationApiClientInterface;
use App\Http\Services\TodoistApiClient;
use App\Models\User;

class RoutineWatcherService
{
    public function getApiClient(User $user)
    {
        return new TodoistApiClient($user->todo_application->access_token);
    }

    public function getAllProjects(TodoApplicationApiClientInterface $api_client)
    {
        return $api_client->getAllProjects();
    }

    public function getAllTags(TodoApplicationApiClientInterface $api_client)
    {
        return $api_client->getAllTags();
    }
}
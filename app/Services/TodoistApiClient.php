<?php


namespace App\Services;


use Illuminate\Support\Facades\Http;

class TodoistApiClient implements TodoApplicationApiClientInterface
{
    protected const API_BASE_URL = 'https://api.todoist.com/sync/v8';
    protected const API_SYNC = '/sync';
    protected const API_GET_ACTIVITY_LOGS = '/activity/get';


    public function __construct(protected string $api_key)
    {
    }

    /* Projects */

    public function getAllProjects(): array
    {
        return $this->postApiToGetProjects()['projects'];
    }

    public function getAllProjectNames(): array
    {
        return array_column($this->postApiToGetProjects()['projects'],'name','id');
    }

    private function postApiToGetProjects() :array
    {
        $response = Http::asForm()->post(self::API_BASE_URL . self::API_SYNC, [
            'token' => $this->api_key,
            'sync_token' => '*',
            'resource_types' => '["projects"]',
        ]);
        return json_decode($response->body(),true);
    }

    /* Tags */

    public function getAllTagNames(): array
    {
        return array_column($this->postApiToGetTags()['labels'],'name','id');
    }

    public function getAllTags(): array
    {
        return $this->postApiToGetTags();
    }

    public function postApiToGetTags(): array
    {
        $response = Http::asForm()->post(self::API_BASE_URL . self::API_SYNC, [
            'token' => $this->api_key,
            'sync_token' => '*',
            'resource_types' => '["labels"]',
        ]);
        return json_decode($response->body(),true);
    }

    /* Todos */

    public function getAllTodoNames(): array
    {
        return array_column($this->postApiToGetTodos()['items'],'content','id');
    }

    public function getAllTodos(): array
    {
        return $this->postApiToGetTodos()['items'];
    }

    private function postApiToGetTodos(): array
    {
        $response = Http::asForm()->post(self::API_BASE_URL . self::API_SYNC, [
            'token' => $this->api_key,
            'sync_token' => '*',
            'resource_types' => '["items"]',
        ]);
        return json_decode($response->body(),true);
    }

    /* ActivityLogs */

    public function getAllTodoDonetimes(): array
    {
        return $this->postApiToGetActivityLogs();
    }

    private function postApiToGetActivityLogs(): array
    {
        $response = Http::asForm()->post(self::API_BASE_URL . self::API_GET_ACTIVITY_LOGS, [
            'token' => $this->api_key,
        ]);
        return json_decode($response->body(),true);
    }

}

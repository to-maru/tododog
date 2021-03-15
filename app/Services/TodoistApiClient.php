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
        $event_type = 'completed';
        return $this->postApiToGetActivityLogs(event_type: $event_type);
    }

    private function postApiToGetActivityLogs(
        string $object_type = null,
        int $object_id = null,
        string $event_type = null,
        int $page = null,
        int $offset = null,
    ): array{
        $payload = [
            'token' => $this->api_key,
            'limit' => 100,
        ];

        if (!is_null($object_type)) {
            $payload['object_type'] = $object_type;
        }
        if (!is_null($object_id)) {
            $payload['object_id'] = $object_id;
        }
        if (!is_null($event_type)) {
            $payload['event_type'] = $event_type;
        }
        if (!is_null($page)) {
            $payload['page'] = $page;
        }
        if (!is_null($offset)) {
            $payload['offset'] = $offset;
        }

        info($payload);
        $response = Http::asForm()->post(self::API_BASE_URL . self::API_GET_ACTIVITY_LOGS, $payload);
        return json_decode($response->body(),true);
    }

}

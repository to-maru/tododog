<?php


namespace App\Services;


use App\Models\TodoApplication;
use Illuminate\Support\Facades\Http;

class TodoistApiClient implements TodoApplicationApiClientInterface
{
    protected const API_BASE_URL = 'https://api.todoist.com/sync/v8';
    protected const API_SYNC = '/sync';
    protected const API_GET_ACTIVITY_LOGS = '/activity/get';


    public function __construct(
        protected string $api_key,
        protected TodoApplication $todo_application
    )
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
        $origin_created_at = $this->todo_application->origin_created_at;
        $done_times_arr = [];
        for ($i = 0; $i <= 20; $i++) {
            $offset = 0;
            do {
                $response = $this->postApiToGetActivityLogs(event_type: $event_type, page: $i, offset: $offset);
                $count = $response['count'];
                $done_times_arr = array_merge(
                    $done_times_arr,
                    $response['events']
                );
                $offset += 100;
            } while ($offset < $count); //$count=100のときは1回のリクエストで取得出来るため
        }
        return $all_done_times = array_merge($done_times_arr);
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

        $response = Http::asForm()->post(self::API_BASE_URL . self::API_GET_ACTIVITY_LOGS, $payload);
        return json_decode($response->body(),true);
    }

}

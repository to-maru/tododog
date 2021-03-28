<?php


namespace App\Services;


use App\Models\TodoApplication;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TodoistApiClient implements TodoApplicationApiClientInterface
{
    protected const API_BASE_URL = 'https://api.todoist.com/sync/v8';
    protected const API_SYNC = '/sync';
    protected const API_GET_ACTIVITY_LOGS = '/activity/get';
    protected const COMMAND_TO_UPDATE_ITEM = 'item_update';


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

    public function updateTodos(array $todo_update_orders): array
    {
        $commands = [];
        foreach ($todo_update_orders as $todo_update_order) {
            $commands = array_merge($commands, $this->getUpdateItemCommands($todo_update_order));
        }
        return $this->postApiToWriteResources($commands);
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
        $from_date = new Carbon($this->todo_application->origin_created_at);
        if (isset($this->todo_application->synced_at)) {
            $from_date = new Carbon($this->todo_application->synced_at);
        }
        $diff_week_num = $from_date->diffInWeeks(Carbon::today()) + 1;
        $done_times_arr = [];
        for ($i = 0; $i <= $diff_week_num; $i++) {
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

    /* WriteResources */
    private function postApiToWriteResources(array $commands): array
    {
        $response = Http::asForm()->post(self::API_BASE_URL . self::API_SYNC, [
            'token' => $this->api_key,
            'commands' => $commands,
        ]);

        return json_decode($response->body(),true);
    }

    private function getWriteResourceCommand(string $type, array $args, string $temp_id = null): array
    {
        $command = array (
            'type' => $type,
            'uuid' => (string) Str::uuid(),
            'args' => $args,
        );
        if (isset($temp_id)) {
            $command['temp_id'] = $temp_id;
        }

        return $command;
    }

    private function getUpdateItemCommands(TodoUpdateOrder $todo_update_order): array
    {
        $commands = [];
        $args = array (
            'id' => $todo_update_order->local_id,
        );
        $commands[] = $this->getWriteResourceCommand(self::COMMAND_TO_UPDATE_ITEM, $args);

        return $commands;
    }

}

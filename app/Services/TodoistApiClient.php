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
    protected const COMMAND_TO_UPDATE_TODO = 'item_update';
    protected const COMMAND_TO_ADD_TAG = 'label_add';
    protected const COMMAND_TO_DELETE_TAG = 'label_delete';


    public function __construct(
        protected string $api_key,
        protected TodoApplication $todo_application
    )
    {

    }

    /* Projects */

    public function fetchAllProjects(): array //fetch
    {
        return $this->postApiToGetProjects()['projects'];
    }

    public function fetchAllProjectNames(): array //fetch
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

    public function fetchAllTagNames(): array //fetch
    {
        return array_column($this->postApiToGetTags()['labels'],'name','id');
    }

    public function fetchAllTags(): array //fetch
    {
        return $this->postApiToGetTags();
    }

    public function pushNewTag(string $name): int
    {
        return $this->postApiToAddTag($name);
    }

    public function pushDeletedTags(array $ids): array
    {
        $commands = array_map(function (int $id) {
            $args['id'] = $id;
            return $this->makeWriteResourceCommand(self::COMMAND_TO_DELETE_TAG, $args);
        }, $ids);
        return $this->postApiToWriteResources($commands);
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

    private function postApiToAddTag(string $name): int
    {
        $args = array(
            'name' => $name,
        );
        $temp_id = (string) Str::uuid();
        $command = $this->makeWriteResourceCommand('label_add', $args, $temp_id);
        $response = $this->postApiToWriteResources(array($command));
        return $response['temp_id_mapping'][$temp_id];
    }

    /* Todos */

    public function fetchAllTodoNames(): array //fetch
    {
        return array_column($this->postApiToGetTodos()['items'],'content','id');
    }

    public function fetchAllTodos(): array //fetch
    {
        return $this->postApiToGetTodos()['items'];
    }

    public function pushTodos(array $todo_update_orders): array
    {
        $commands = [];
        foreach ($todo_update_orders as $todo_update_order) {
            if ($todo_update_order->existsAnyUpdate()) {
                $commands = array_merge($commands, $this->makeUpdateItemCommands($todo_update_order));
            }
        }
        if (empty($commands)) {
            return [];
        }
        $chunked_commands = array_chunk($commands,100);
        $responses = array();
        foreach ($chunked_commands as $chunked_command) {
            $responses[] = $this->postApiToWriteResources($chunked_command);
        }
        return $responses;
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

    public function fetchAllTodoDonetimes(): array //fetch
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
            'commands' => json_encode($commands),
        ]);

        return json_decode($response->body(),true);
    }

    private function makeWriteResourceCommand(string $type, array $args, string $temp_id = null): array //build
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

    private function makeUpdateItemCommands(TodoUpdateOrder $todo_update_order): array //generateWriteResourceCommandFromTodoUpdateOrder
    {
        $commands = [];

        $args = array (
            'id' => $todo_update_order->original->local_id,
        );
        if ($todo_update_order->existsNameUpdate()) {
            $args['content'] = $todo_update_order->name;
        }
        if ($todo_update_order->existsTagUpdate()) {
            $args['labels'] = $todo_update_order->tag_ids;
        }
        $commands[] = $this->makeWriteResourceCommand(self::COMMAND_TO_UPDATE_TODO, $args);
        return $commands;
    }

}

<?php


namespace App\Http\Services;


use Illuminate\Support\Facades\Http;

class TodoistApiClient implements TodoApplicationApiClientInterface
{
    public function __construct(protected string $api_key)
    {
    }

    public function getAllProjects(): array
    {
        $response = Http::asForm()->post('https://api.todoist.com/sync/v8/sync', [
            'token' => $this->api_key,
            'sync_token' => '*',
            'resource_types' => '["projects"]',
        ]);
        return $response->body();
    }

    public function getAllTags(): array
    {
        $response = Http::asForm()->post('https://api.todoist.com/sync/v8/sync', [
            'token' => $this->api_key,
            'sync_token' => '*',
            'resource_types' => '["projects"]',
        ]);
        return $response->body();
    }
}

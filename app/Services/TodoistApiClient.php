<?php


namespace App\Services;


use Illuminate\Support\Facades\Http;

class TodoistApiClient implements TodoApplicationApiClientInterface
{
    protected const API_BASE_URL = 'https://api.todoist.com/sync/v8/sync';


    public function __construct(protected string $api_key)
    {
    }

    public function getAllProjects(): array
    {
        $response = Http::asForm()->post(self::API_BASE_URL, [
            'token' => $this->api_key,
            'sync_token' => '*',
            'resource_types' => '["projects"]',
        ]);
        return array_column(json_decode($response->body(),true)['projects'],'name','id');
    }

    public function getAllTags(): array
    {
        $response = Http::asForm()->post(self::API_BASE_URL, [
            'token' => $this->api_key,
            'sync_token' => '*',
            'resource_types' => '["labels"]',
        ]);
        return array_column(json_decode($response->body(),true)['labels'],'name','id');
    }

    public function getAllTodos(): array
    {
        return array_column($this->postApiToGetTodos()['items'],'content','id');
    }

    private function postApiToGetTodos(): array
    {
        $response = Http::asForm()->post(self::API_BASE_URL, [
            'token' => $this->api_key,
            'sync_token' => '*',
            'resource_types' => '["items"]',
        ]);
        return json_decode($response->body(),true);
    }

}

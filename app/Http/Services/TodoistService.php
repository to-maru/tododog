<?php


namespace App\Http\Services;


use Illuminate\Support\Facades\Http;

class TodoistService
{
    protected $api_key;

    public function __construct($api_key = null)
    {
        $this->api_key = $api_key;
    }

    public function getAllProjects()
    {
        $response = Http::asForm()->post('https://api.todoist.com/sync/v8/sync', [
            'token' => $this->api_key,
            'sync_token' => '*',
            'resource_types' => '["projects"]',
        ]);
        return $response->body();
    }

}

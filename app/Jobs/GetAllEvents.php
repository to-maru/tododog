<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class GetAllEvents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = Http::asForm()->post('https://api.todoist.com/sync/v8/activity/get', [
            'token' => config('todoapp.todoist.api_key'),
            'limit' => 100,
        ]);
        $data = json_decode($response->body());
        echo(json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
    }
}

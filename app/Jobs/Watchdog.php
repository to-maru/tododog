<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Synchronizer;
use App\Services\Analyzer;


class Watchdog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public function __construct(
        public User $user
    ) {
        //
    }

    public function handle(
        Synchronizer $synchronizer,
        Analyzer $analyzer
    )
    {
        $synchronizer->api_client = $synchronizer->getApiClient($this->user->todo_application);
        $synchronizer->syncronizeTodo($this->user->todo_application);
        $analyzer->analyze($this->user);
    }
}

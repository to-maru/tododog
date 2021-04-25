<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\Notifier;
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
        Analyzer $analyzer,
        Notifier $notifier,
    )
    {
        $synchronizer->api_client = $synchronizer->getApiClient($this->user->todo_application);
        $synchronizer->pullTodosAndDonetimes($this->user->todo_application);
        $notifier->api_client = $notifier->getApiClient($this->user->todo_application);
        $notifier->notify($analyzer->analyze($this->user));
        $synchronizer->pullTodosAndDonetimes($this->user->todo_application);
    }
}

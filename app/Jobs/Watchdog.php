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
use Illuminate\Support\Facades\Log;


class Watchdog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $timeout = 600;

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
        Log::info('['.self::class.'] '.'start', ['user_id' => $this->user->id]);

        $synchronizer->api_client = $synchronizer->getApiClient($this->user->todo_application);
        $synchronizer->pullTodosAndDonetimes($this->user->todo_application);
        Log::info('['.self::class.'] '.'pulled todos', ['user_id' => $this->user->id]);

        $notifier->api_client = $notifier->getApiClient($this->user->todo_application);
        $analyzed = $analyzer->analyze($this->user);
        Log::info('['.self::class.'] '.'analyzed', ['user_id' => $this->user->id]);

        $notifier->notify($analyzed);
        Log::info('['.self::class.'] '.'notified', ['user_id' => $this->user->id]);

        $synchronizer->pullTodosAndDonetimes($this->user->todo_application);
        Log::info('['.self::class.'] '.'pulled todos again', ['user_id' => $this->user->id]);

        Log::info('['.self::class.'] '.'end', ['user_id' => $this->user->id]);
    }
}

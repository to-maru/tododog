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
use App\Services\TodoApplicationSynchronizer;
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
        TodoApplicationSynchronizer $synchronizer,
        Analyzer $analyzer
    )
    {
        info($this->user->todo_application);
        $synchronizer->setApiClient($this->user->todo_application);
        $synchronizer->syncronizeTodo(); //syncromizeTodoAndDonedate の方がいいかも
        $analyzer;
    }
}

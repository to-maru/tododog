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

    /**
     * Create a new job instance.
     *
     * @param TodoApplicationSynchronizer $synchronizer
     * @param Analyzer $analyzer
     * @return void
     */
    public function __construct(
        public TodoApplicationSynchronizer $synchronizer,
        public Analyzer $analyzer
    ) {
        //
    }

    /**
     * Execute the job.
     *
     * @param User $user
     * @return void
     */
    public function handle(User $user)
    {
        $this->synchronizer->syncronizeTodo($user->todo_application);
        $this->analyzer;
    }
}

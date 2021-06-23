<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserDeleter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public User $user
    )
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
        Log::info('['.self::class.'] '.'start', ['user_id' => $this->user->id]);
        Cleaner::dispatchSync($this->user);
        $destroying_user_id = $this->user->id;
        User::destroy($this->user->id);
        Log::info('['.self::class.'] '.'end', ['user_id' => $destroying_user_id]);
    }
}

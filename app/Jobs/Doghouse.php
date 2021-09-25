<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Throwable;

class Doghouse implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 6000;

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
        Log::info('['.self::class.'] '.'start');
        $users = User::with('user_setting_analysis')
            ->get()
            ->filter(function ($user) {
                return $user->user_setting_analysis->autorun_enabled ?? false;
            });

        if ($users->isEmpty()) {
            Log::info('['.self::class.'] '.'batch not run');
            Log::info('['.self::class.'] '.'end');
            return;
        }

        $batch_list = [];
        foreach ($users as $user) {
            $batch_list[] = new Watchdog($user);
        }

        $batch = Bus::batch($batch_list)
            ->then(function (Batch $batch) {
                Log::info('['.self::class.'] '.'batch success');
                // すべてのジョブが正常に完了
            })
            ->catch(function (Batch $batch, Throwable $e) {
                Log::error('['.self::class.'] '.'batch failure', ['error' => $e]);
                // バッチジョブの失敗をはじめて検出
            })
            ->finally(function (Batch $batch) {
                Log::info('['.self::class.'] '.'batch ended');
                // バッチの実行が終了
            })
            ->onConnection('sync')
            ->dispatch();
        Log::info('['.self::class.'] '.'end');
    }
}

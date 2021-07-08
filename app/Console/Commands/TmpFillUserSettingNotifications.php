<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserSettingNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TmpFillUserSettingNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmp:fix:u_s_n:1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'userにuser_setting_notificationsが紐づいていない場合は新規発行する';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        //soft deleteは除外されている
        $users = User::all();

        $users->each(function ($user) {
            if (empty($user->user_setting_notification)) {
                $user->user_setting_notification()->save(new UserSettingNotification);
                Log::info('['.self::class.'] '. 'notification created', [
                    'user.id' => $user->id,
                    'user_settings_notification.id' => $user->fresh()->user_setting_notification->id,
                ]);
            } else {
                Log::info('['.self::class.'] '. 'notification not created', [
                    'users.id' => $user->id,
                ]);
            }
        });
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\UserSettingAnalysis;
use App\Models\TodoApplication;
use App\Models\User;
use App\Models\UserSettingNotification;
use \RuntimeException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ApiAuthTodoistController extends Controller
{
    public function call(Request $request)
    {
        $request->session()->put('state', $state = (string) Str::uuid());
        $query = http_build_query([
            'client_id' => config('todoapp.todoist.client_id'),
//            'redirect_uri' => '',
//            'response_type' => 'code',
            'scope' => 'data:read_write',
            'state' => $state,
        ]);
        return redirect('https://todoist.com/oauth/authorize?' . $query);
    }

    public function callback(Request $request)
    {
        try {
            $state = $request->session()->pull('state');

            throw_unless(
                strlen($state) > 0 && $state === $request->state,
                RuntimeException::class,
                '認証で用いるstateの値が不適切です',
            );
        } catch (RuntimeException $e) {
            Log::error(
                '['.self::class.'] '. $e->getMessage(),
                [
                    'request' => $request,
                    'request_state' => $request->state ?? '',
                    'session_state' => $state ?? '',
                ]
            );
            session()->flash('msg_danger', '認証エラーが発生しました。');
            return redirect()->route('login');
        }

        $access_token_response = Http::asForm()->post('https://todoist.com/oauth/access_token', [
            'code' => $request->code,
            'client_id' => config('todoapp.todoist.client_id'),
            'client_secret' => config('todoapp.todoist.client_secret'),
        ]);

        $access_token = json_decode($access_token_response->body(), true)['access_token'];

        $user_sync_response = Http::asForm()->post('https://api.todoist.com/sync/v8/sync', [
            'token' => $access_token,
            'sync_token' => '*',
            'resource_types' => '["user"]',
        ]);
        $user_data = json_decode($user_sync_response->body(), true)['user'];

        $todo_application = TodoApplication::firstOrNew(
            [
                'type_id' => 1,
                'application_user_id' => $user_data['id'],
            ],[
                'access_token' => $access_token,
                'origin_created_at' => $user_data['join_date'],
                'raw_data' => json_encode($user_data),
            ]
        );

        DB::transaction(function () use ($todo_application, $user_data) {
            if (is_null($todo_application->id)) {
                $user = User::create([
                    'name' => $user_data['full_name']
                ]);
                $todo_application->id = $user->id;

                $user->user_setting_analysis()->save(new UserSettingAnalysis);
                $user->user_setting_notification()->save(new UserSettingNotification);
            }

            $todo_application->save();
        });

        Auth::login($todo_application->user);
        return redirect()->route('dashboard');
    }
}

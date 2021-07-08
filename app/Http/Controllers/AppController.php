<?php

namespace App\Http\Controllers;

use App\Jobs\Cleaner;
use App\Jobs\Watchdog;
use Illuminate\Http\Request;
use App\Traits\TodoApplicationApiClientTrait;

class AppController extends Controller
{
    use TodoApplicationApiClientTrait;

    public function __construct()
    {
    }

    public function show(Request $request)
    {
        $user = $request->user();
        $user_setting_analysis = $user->user_setting_analysis;
        $user_setting_notification = $user->user_setting_notification;

        $user_setting_analysis->tag_ids = json_decode($user_setting_analysis->tag_ids);
        $api_client = $this->getApiClient($user->todo_application);

        $projects = $this->fetchAllProjectNames($api_client);
        $tags = $this->fetchAllTagNames($api_client);

        return view('dashboard', [
            'user' => $user,
            'setting_analysis' => $user_setting_analysis,
            'setting_notification' => $user_setting_notification,
            'projects' => $projects,
            'tags' => $tags,
            'synced_at' => $user->todo_application->synced_at ? $user->todo_application->synced_at->format('Y/m/d H:i:s') : null,
        ]);
    }

    public function run(Request $request)
    {
        $user = $request->user();
        Watchdog::dispatch($user);
        session()->flash('msg_success', '分析を開始します。');
        return redirect()->action($this::class . '@' . 'show');
    }

    public function autorun(Request $request)
    {
        $user = $request->user();
        $user_setting_analysis = $user->user_setting_analysis;
        $user_setting_analysis->autorun_enabled = $request->enable;
        $user_setting_analysis->save();
        $user_setting_analysis->refresh();
        if ($user_setting_analysis->autorun_enabled) {
            session()->flash('msg_success', '自動実行を有効化しました。');
        } else {
            session()->flash('msg_success', '自動実行を無効化しました。');
        }
        return redirect()->action($this::class . '@' . 'show');
    }

    public function revert(Request $request)
    {
        $user = $request->user();
        Cleaner::dispatch($user);
        session()->flash('msg_success', '分析結果の消去を開始します。');
        return redirect()->action($this::class . '@' . 'show');
    }
}

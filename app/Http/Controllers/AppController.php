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
        $routine_watcher_setting = $user->routine_watcher_setting;

        $routine_watcher_setting->tag_ids = json_decode($routine_watcher_setting->tag_ids);
        $api_client = $this->getApiClient($user->todo_application);

        $projects = $this->fetchAllProjectNames($api_client);
        $tags = $this->fetchAllTagNames($api_client);

        return view('dashboard', [
            'user' => $user,
            'setting' => $routine_watcher_setting,
            'projects' => $projects,
            'tags' => $tags,
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $routine_watcher_setting = $user->routine_watcher_setting;
        $routine_watcher_setting->project_id = $request->project_id;
        $routine_watcher_setting->tag_ids = json_encode($request->tag_ids);
        $routine_watcher_setting->project_id = $request->project_id;
        $routine_watcher_setting->cheat_day_enabled = $request->cheat_day_enabled === 'on';
        $routine_watcher_setting->cheat_day_interval = $request->cheat_day_interval;
        $routine_watcher_setting->footprints_number = $request->footprints_number;
        $routine_watcher_setting->autorun_enabled = $request->autorun_enabled === 'on';
        $routine_watcher_setting->save();

        return redirect()->action($this::class . '@' . 'show');
    }

    public function run(Request $request)
    {
        $user = $request->user();
        Watchdog::dispatch($user);
        return redirect()->action($this::class . '@' . 'show');
    }

    public function autorun(Request $request)
    {
        $user = $request->user();
        $routine_watcher_setting = $user->routine_watcher_setting;
        $routine_watcher_setting->autorun_enabled = $request->enable;
        $routine_watcher_setting->save();
        return redirect()->action($this::class . '@' . 'show');
    }

    public function revert(Request $request)
    {
        $user = $request->user();
        Cleaner::dispatch($user);
        return redirect()->action($this::class . '@' . 'show');
    }
}

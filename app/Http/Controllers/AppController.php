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

        $user_setting_analysis->tag_ids = json_decode($user_setting_analysis->tag_ids);
        $api_client = $this->getApiClient($user->todo_application);

        $projects = $this->fetchAllProjectNames($api_client);
        $tags = $this->fetchAllTagNames($api_client);

        return view('dashboard', [
            'user' => $user,
            'setting' => $user_setting_analysis,
            'projects' => $projects,
            'tags' => $tags,
            'synced_at' => $user->todo_application->synced_at,
        ]);
    }

    public function run(Request $request)
    {
        $user = $request->user();
        Watchdog::dispatch($user);
        return redirect()->action($this::class . '@' . 'show'); //todo: messageを表示させたい
    }

    public function autorun(Request $request)
    {
        $user = $request->user();
        $user_setting_analysis = $user->user_setting_analysis;
        $user_setting_analysis->autorun_enabled = $request->enable;
        $user_setting_analysis->save();
        return redirect()->action($this::class . '@' . 'show'); //todo: messageを表示させたい
    }

    public function revert(Request $request)
    {
        $user = $request->user();
        Cleaner::dispatch($user);
        return redirect()->action($this::class . '@' . 'show'); //todo: messageを表示させたい
    }
}

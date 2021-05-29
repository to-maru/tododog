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
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $user_setting_analysis = $user->user_setting_analysis;
        $user_setting_analysis->project_id = $request->project_id;
        $user_setting_analysis->tag_ids = json_encode($request->tag_ids);
        $user_setting_analysis->project_id = $request->project_id;
        $user_setting_analysis->cheat_day_enabled = $request->cheat_day_enabled === 'on';
        $user_setting_analysis->cheat_day_interval = $request->cheat_day_interval;
        $user_setting_analysis->footprints_number = $request->footprints_number;
        $user_setting_analysis->autorun_enabled = $request->autorun_enabled === 'on';
        $user_setting_analysis->save();

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
        $user_setting_analysis = $user->user_setting_analysis;
        $user_setting_analysis->autorun_enabled = $request->enable;
        $user_setting_analysis->save();
        return redirect()->action($this::class . '@' . 'show');
    }

    public function revert(Request $request)
    {
        $user = $request->user();
        Cleaner::dispatch($user);
        return redirect()->action($this::class . '@' . 'show');
    }
}

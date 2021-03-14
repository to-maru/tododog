<?php

namespace App\Http\Controllers;

use App\Services\Pages\RoutineWatcherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\TodoApplicationApiClientTrait;

class RoutineWatcherController extends Controller
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

        $projects = $this->getAllProjects($api_client);
        $tags = $this->getAllTags($api_client);

        return view('routine_watcher', [
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
        $routine_watcher_setting->save();

        return redirect()->action($this::class . '@' . 'show');
    }
}

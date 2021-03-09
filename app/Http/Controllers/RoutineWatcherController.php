<?php

namespace App\Http\Controllers;

use App\Http\Services\Pages\RoutineWatcherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoutineWatcherController extends Controller
{
    public function __construct(protected RoutineWatcherService $page_service)
    {
    }

    public function show(Request $request)
    {
        $user = $request->user();
        $routine_watcher_setting = $user->routine_watcher_setting;
        info($routine_watcher_setting);

        $routine_watcher_setting->tag_ids = json_decode($routine_watcher_setting->tag_ids);
        $api_client = $this->page_service->getApiClient($user);

        $projects = $this->page_service->getAllProjects($api_client);
        $tags = $this->page_service->getAllTags($api_client);

        return view('routine_watcher', [
            'user' => $user,
            'setting' => $routine_watcher_setting,
            'projects' => $projects,
            'tags' => $tags,
        ]);
    }

    public function update(Request $request)
    {
        info($request);
        $user = $request->user();
        $routine_watcher_setting = $user->routine_watcher_setting;
        $routine_watcher_setting->project_id = $request->project_id;
        $routine_watcher_setting->tag_ids = json_encode($request->tag_ids);
        $routine_watcher_setting->save();

        $routine_watcher_setting->tag_ids = json_decode($routine_watcher_setting->tag_ids);
        $api_client = $this->page_service->getApiClient($user);

        $projects = $this->page_service->getAllProjects($api_client);
        $tags = $this->page_service->getAllTags($api_client);
        info($routine_watcher_setting);

        return view('routine_watcher', [
            'user' => $user,
            'setting' => $routine_watcher_setting,
            'projects' => $projects,
            'tags' => $tags,
        ]);
    }
}

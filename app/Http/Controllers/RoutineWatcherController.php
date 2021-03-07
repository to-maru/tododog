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

        $api_client = $this->page_service->getApiClient($user);

        $projects = $this->page_service->getAllProjects();
        $tags = $this->page_service->getAllTags();

        return view('routine_watcher', [
            'user' => $user,
            'setting' => $routine_watcher_setting,
        ]);
    }
}

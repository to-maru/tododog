<?php

namespace App\Http\Controllers;

use App\Jobs\UserDeleter;
use Illuminate\Http\Request;
use App\Traits\TodoApplicationApiClientTrait;
use Illuminate\Support\Facades\Auth;

class SettingUserController extends Controller
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

        return view('setting_user', [
            'user' => $user,
            'setting' => $user_setting_analysis,
            'projects' => $projects,
            'tags' => $tags,
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'name' => 'required|string|between:4,32',
        ], [
            'required' => '入力必須です。'
        ]);
        $user->name = $validated['name'];
        $user->save();

        session()->flash('msg_success', '設定を更新しました。');
        return redirect()->action($this::class . '@' . 'show');
    }

    public function delete(Request $request)
    {
        $user = $request->user();
        UserDeleter::dispatch($user);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

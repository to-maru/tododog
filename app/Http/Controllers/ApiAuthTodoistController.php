<?php

namespace App\Http\Controllers;

use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ApiAuthTodoistController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->put('state', $state = Str::random(40));
        $query = http_build_query([
            'client_id' => config('todoapp.todoist.client_id'),
//            'redirect_uri' => '',
//            'response_type' => 'code',
            'scope' => 'data:read_write',
            'state' => $state,
        ]);

        return redirect('https://todoist.com/oauth/authorize?'.$query);
    }

    public function callback(Request $request)
    {
        $state = $request->session()->pull('state');

        throw_unless(
            strlen($state) > 0 && $state === $request->state,
            \App\Exceptions\Handler::class
        );
        $access_token_response = Http::asForm()->post('https://todoist.com/oauth/access_token', [
            'code' => $request->code,
            'client_id' => config('todoapp.todoist.client_id'),
            'client_secret' => config('todoapp.todoist.client_secret'),
        ]);

        //todo: error handling

        $access_token = json_decode($access_token_response->body(), true)['access_token'];

        $user_sync_response = Http::asForm()->post('https://api.todoist.com/sync/v8/sync', [
            'token' => $access_token,
            'sync_token' => '*',
            'resource_types' => '["user"]',
        ]);
        $user = json_decode($user_sync_response->body(),true)['user'];

        return redirect()->route('dashboard');
    }
}

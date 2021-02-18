<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', Controllers\HomeController::class)->name('login');
Route::get('/api/auth/todoist', Controllers\ApiAuthTodoistController::class . '@' . 'index');
Route::get('/api/auth/todoist/callback', Controllers\ApiAuthTodoistController::class . '@' . 'callback');

Route::middleware('auth')->group(function () {
    Route::get('/settings', function () {
        return view('settings'); //todo: 後で作る
    })->name('dashboard');
});

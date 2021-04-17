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
Route::get('/api/auth/todoist', Controllers\ApiAuthTodoistController::class . '@' . 'call');
Route::get('/api/auth/todoist/callback', Controllers\ApiAuthTodoistController::class . '@' . 'callback');

Route::middleware('auth')->group(function () {
    Route::get('/user/sign_out',Controllers\SignOutController::class)->name('logout');
    Route::get('/routine_watcher', Controllers\RoutineWatcherController::class . '@' . 'show')->name('dashboard');
    Route::post('/routine_watcher', Controllers\RoutineWatcherController::class . '@' . 'update');
    Route::get('/routine_watcher/run', Controllers\RoutineWatcherController::class . '@' . 'run');
    Route::get('/routine_watcher/reset', Controllers\RoutineWatcherController::class . '@' . 'clean');
});

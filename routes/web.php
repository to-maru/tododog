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

Route::middleware('auth.very_basic')->group(function () {
    Route::get('/', Controllers\HomeController::class)->name('login');
    Route::get('/api/auth/todoist/call', Controllers\ApiAuthTodoistController::class . '@' . 'call');
    Route::get('/api/auth/todoist/callback', Controllers\ApiAuthTodoistController::class . '@' . 'callback');
});

Route::middleware(['auth.very_basic', 'auth'])->group(function () {
    Route::get('/user/sign_out', Controllers\UserController::class . '@' . 'sign_out')->name('logout');
    Route::get('/app', Controllers\AppController::class . '@' . 'show')->name('dashboard');
    Route::get('/app/run', Controllers\AppController::class . '@' . 'run');
    Route::get('/app/autorun', Controllers\AppController::class . '@' . 'autorun');
    Route::get('/app/revert', Controllers\AppController::class . '@' . 'revert');
    Route::redirect('/settings', '/settings/analysis');
    Route::get('/settings/analysis', Controllers\SettingAnalysisController::class . '@' . 'show');
    Route::post('/settings/analysis', Controllers\SettingAnalysisController::class . '@' . 'update');
});

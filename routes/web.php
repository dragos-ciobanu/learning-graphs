<?php

use App\Http\Controllers\GraphController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
});

Route::get('/graph/bfs', [GraphController::class, 'showBFS']);
Route::get('/graph/dfs/{start}', [GraphController::class, 'showDFS']);
Route::get('/graph/clica', [GraphController::class, 'clica']);
Route::get('/graph/circle/{start}', [GraphController::class, 'circle']);

Route::get('/welcome', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

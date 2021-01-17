<?php

use App\Http\Controllers\GraphController;
use App\Http\Controllers\HomeController;
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

Route::match(['get', 'post'],'/graph/bfs/{start?}', [GraphController::class, 'showBFS'])->middleware('graph.populate');
Route::match(['get', 'post'],'/graph/dfs/{start?}', [GraphController::class, 'showDFS'])->middleware('graph.populate');
Route::match(['get', 'post'],'/graph/clique', [GraphController::class, 'clique'])->middleware('graph.populate');
Route::match(['get', 'post'],'/graph/circle/{start?}', [GraphController::class, 'circle'])->middleware('graph.populate');
Route::get('/reset', [HomeController::class, 'reset']);

Route::get('/welcome', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

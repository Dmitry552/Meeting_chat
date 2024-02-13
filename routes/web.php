<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\User\AuthUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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
Route::get('/auth/{provider}/redirect', [AuthUserController::class, 'redirectOAuth']);
Route::get('/auth/{provider}/callback', [AuthUserController::class, 'loginOAuth']);


Route::get('/room', [RoomController::class, 'create']);

Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)')
    ->name('home');

Route::get('password/reset/{token}', function () {
    return view('index');
})->name('password.reset');

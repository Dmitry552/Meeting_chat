<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\SystemRoomController;
use App\Http\Controllers\User\AuthUserController;
use App\Http\Controllers\User\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InterlocutorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthUserController::class, 'login'])->name('login');
Route::post('registration', [UserController::class, 'store']);
Route::post('socialUserData', [UserController::class, 'socialUserData']);

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/forgot-password', [AuthUserController::class, 'forgotPassword'])
    ->middleware('guest:user')
    ->name('password.email');
Route::post('/reset-password', [AuthUserController::class, 'resetPassword'])
    ->middleware('guest:user')
    ->name('password.update');

Route::middleware([
    'interlocutor:user'
])
    ->prefix('interlocutor')
    ->group(function () {
        Route::get('/{interlocutor:code}', [InterlocutorController::class, 'show']);
        Route::post('/', [InterlocutorController::class, 'store']);
        Route::delete('/{interlocutor:code}', [InterlocutorController::class, 'destroy']);
    });

Route::prefix('room')
    ->group(function () {
        Route::post('/{interlocutor}', [RoomController::class, 'store']);
        Route::get('/{room:name}', [RoomController::class, 'show']);
        Route::get('/check/{name}', [RoomController::class, 'check']);
        Route::get('/interlocutors/{room:name}', [InterlocutorController::class, 'interlocutorsRoom']);
        Route::get('/join/{room:name}/{interlocutor}', [RoomController::class, 'joinRoom']);
    });

Route::middleware([
    'auth:user'
])
    ->prefix('room')
    ->group(function () {
        Route::get('/roomsBetweenDates', [SystemRoomController::class, 'getRoomsBetweenDates']);
    });

Route::middleware([
    'auth:user',
])
    ->prefix('user')
    ->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('me', [AuthUserController::class, 'me']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::post('logout', [AuthUserController::class, 'logout']);
        Route::post('refresh', [AuthUserController::class, 'refresh']);
        Route::post('avatar', [UserController::class, 'avatar']);
        Route::post('password/{user}', [UserController::class, 'password']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::delete('avatar', [UserController::class, 'destroyAvatar']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });

Route::prefix('videoChat')
    ->group(function () {
        require __DIR__ ."/channels/videoChat/videoChat.php";
    });

Route::prefix('textChat')
    ->group(function () {
        require __DIR__ ."/channels/textChat/textChat.php";
    });

<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\User\AuthUserController;
use App\Http\Controllers\User\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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
   Route::post('/', [InterlocutorController::class, 'store']);
});

Route::post('/room/{interlocutor}', [RoomController::class, 'store']);
Route::get('/room/{room:name}', [RoomController::class, 'show']);
Route::get('/room/check/{name}', [RoomController::class, 'check']);
Route::get('/room/interlocutors/{room:name}', [InterlocutorController::class, 'interlocutorsRoom']);
Route::get('/room/join/{room:name}/{interlocutor}', [RoomController::class, 'joinRoom']);

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
        Route::post('avatar', [UserController::class, 'avatar']); //TODO: add to swagger
        Route::post('password/{user}', [UserController::class, 'password']); //TODO: add to swagger
        Route::put('/{user}', [UserController::class, 'update']);
        Route::delete('avatar', [UserController::class, 'destroyAvatar']); //TODO: add to swagger
        Route::delete('/{user}', [UserController::class, 'destroy']);
});

Route::middleware([
    'interlocutor:user',
])
    ->prefix('videoChat')
    ->group(function () {
        require __DIR__ ."/channels/videoChat/videoChat.php";
    });

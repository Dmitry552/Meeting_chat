<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\User\AuthUserController;
use App\Http\Controllers\User\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::post('/room', [RoomController::class, 'create']);

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

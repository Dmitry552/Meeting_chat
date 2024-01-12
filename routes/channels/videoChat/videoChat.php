<?php

use App\Http\Controllers\VideoChatController;
use Illuminate\Support\Facades\Route;

Route::get('join/{room:name}/{interlocutor:code}', [VideoChatController::class, 'join'])->withoutScopedBindings();
Route::get('leave/{room:name}/{interlocutor:code}', [VideoChatController::class, 'leave'])->withoutScopedBindings();
Route::post('relayIce/{room:name}/{interlocutor:code}', [VideoChatController::class, 'relayIce'])->withoutScopedBindings();
Route::post('relaySdp/{room:name}/{interlocutor:code}', [VideoChatController::class, 'relaySdp'])->withoutScopedBindings();
Route::post('mute/{room:name}/{interlocutor:code}', [VideoChatController::class, 'mute'])->withoutScopedBindings();

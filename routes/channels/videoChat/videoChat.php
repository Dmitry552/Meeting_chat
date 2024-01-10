<?php

use App\Http\Controllers\VideoChatController;
use Illuminate\Support\Facades\Route;

Route::get('join/{room:name}/{interlocutor:code}', [VideoChatController::class, 'join']);
Route::get('leave/{room:name}/{interlocutor:code}', [VideoChatController::class, 'leave']);
Route::post('relayIce/{room:name}/{interlocutor:code}', [VideoChatController::class, 'relayIce']);
Route::post('relaySdp/{room:name}/{interlocutor:code}', [VideoChatController::class, 'relaySdp']);
Route::post('mute/{room:name}/{interlocutor:code}', [VideoChatController::class, 'mute']);
<?php

use App\Http\Controllers\VideoChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Events\VideoEvent\JoinRoom;
use App\Models\Room;

Route::post('message', function (Request $request) {
    $message = $request->input('message');
    dump($message);
    event(new \App\Events\Message($message));
});

Route::post('1111/1', function (Request $request, Room $room) {
    event(new \App\Events\Message(
        [
            'hello' => 'world'
        ]
    ));
});
Route::get('join/{room:name}/{interlocutor:code}', [VideoChatController::class, 'join']);
Route::get('leave/{room:name}/{interlocutor:code}', [VideoChatController::class, 'leave']);
Route::post('relayIce/{room:name}/{interlocutor:code}', [VideoChatController::class, 'relayIce']);
Route::post('relaySdp/{room:name}/{interlocutor:code}', [VideoChatController::class, 'relaySdp']);
Route::post('mute/{room:name}/{interlocutor:code}', [VideoChatController::class, 'mute']);
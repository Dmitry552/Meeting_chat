<?php

use App\Http\Controllers\TextChatController;
use Illuminate\Support\Facades\Route;

Route::get('/{room:name}', [TextChatController::class, 'index']);
Route::delete('/{message}', [TextChatController::class, 'destroy']);
Route::post('message/{room:name}/{interlocutor:code}', [TextChatController::class, 'create'])->withoutScopedBindings();

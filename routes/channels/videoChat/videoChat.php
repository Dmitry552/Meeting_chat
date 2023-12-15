<?php

use Illuminate\Support\Facades\Route;

Route::post('message', function (\Illuminate\Http\Request $request) {
    $message = $request->input('message');
    dump($message);
    event(new \App\Events\Message($message));
});
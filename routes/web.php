<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ClientChatController;

Route::post('/chat/name', [ClientChatController::class, 'setName'])->name('client.chat.name');
Route::get('/chat', [ClientChatController::class, 'index'])->name('client.chat');
Route::post('/chat/send', [ClientChatController::class, 'send'])->name('client.chat.send');

Route::get('/', function () {
    return "¡Hola, Laravel funciona!";
});

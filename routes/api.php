<?php

dd('api loaded');

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Cliente envía mensaje
Route::post('/chat/send', [ChatController::class, 'receive']);

// Admin obtiene mensajes de un chat
Route::get('/chat/{chatId}', [ChatController::class, 'getChatMessages']);

// Admin envía mensaje
Route::post('/chat/{chatId}/admin', [ChatController::class, 'sendMessage']);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatBotController;

Route::get('/', function () {
    return "¡Hola, Laravel funciona!";
});

// Rutas para probar el chatbot
Route::get('/test-bot', [ChatBotController::class, 'receive']);
Route::post('/test-bot', [ChatBotController::class, 'receive']);

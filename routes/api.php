<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwilioWebhookController;

Route::get('/test-api', function () {
    return 'API funciona';
});

Route::post('/twilio/webhook', [TwilioWebhookController::class, 'handle'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

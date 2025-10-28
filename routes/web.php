<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ClientChat;
use App\Livewire\AdminChat;

Route::get('/chat', \App\Livewire\ClientChat::class)->name('client.chat');

Route::get('/admin/chat/{chat}', \App\Livewire\AdminChat::class)->name('admin.chat');

Route::get('/', function () {
    return 'Servidor Laravel + Livewire funcionando correctamente';
});

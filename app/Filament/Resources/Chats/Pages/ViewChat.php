<?php

namespace App\Filament\Resources\Chats\Pages;

use App\Filament\Resources\Chats\ChatResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Actions\Action;
use Livewire\Component;
use Filament\Notifications\Notification;
use Livewire\Livewire;


class ViewChat extends ViewRecord
{
    protected static string $resource = ChatResource::class;

    public $newMessage = '';

    protected function getHeaderWidgets(): array
    {
        return [];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        // Esto es opcional si quieres filtrar mensajes del chat actual
        return $this->record->messages();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('sender')->label('Sender'),
            Tables\Columns\TextColumn::make('message')->label('Message'),
            Tables\Columns\TextColumn::make('created_at')->label('Sent At')->dateTime(),
        ];
    }

	public function sendMessage()
{
    // Crear el mensaje
    $this->record->messages()->create([
        'sender' => 'admin',
        'message' => $this->newMessage,
    ]);

    $this->newMessage = '';

    // Mostrar notificación en Filament
    Notification::make()
        ->title('Message sent.')
        ->success()
        ->send();
}

	public function render(): \Illuminate\Contracts\View\View
	{
	    return view('filament.resources.chats.pages.view-chat');
	}
}

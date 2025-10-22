<?php

namespace App\Filament\Resources\Chats\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ChatInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('session_id'),
                TextEntry::make('name')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}

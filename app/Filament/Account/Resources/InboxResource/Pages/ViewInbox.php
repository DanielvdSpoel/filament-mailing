<?php

namespace App\Filament\Account\Resources\InboxResource\Pages;

use App\Filament\Account\Resources\InboxResource;
use App\Models\Inbox;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewInbox extends ViewRecord
{
    protected static string $resource = InboxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('test_connection')
                ->label('Test Connection')
                ->color('gray')
                ->outlined()
                ->action(function (Inbox $record) {
                    $connection = $record->getConnection();
                    $result = $connection->open();
                    if ($result) {
                        Notification::make()
                            ->title('Connection successful')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Connection failed')
                            ->danger()
                            ->send();
                    }
                })
        ];
    }
}

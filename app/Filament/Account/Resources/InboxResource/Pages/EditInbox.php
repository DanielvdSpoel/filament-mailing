<?php

namespace App\Filament\Account\Resources\InboxResource\Pages;

use App\Filament\Account\Resources\InboxResource;
use App\Models\Inbox;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInbox extends EditRecord
{
    protected static string $resource = InboxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ViewAction::make(),
        ];
    }
}

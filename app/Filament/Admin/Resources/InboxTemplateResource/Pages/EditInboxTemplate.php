<?php

namespace App\Filament\Admin\Resources\InboxTemplateResource\Pages;

use App\Filament\Admin\Resources\InboxTemplateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInboxTemplate extends EditRecord
{
    protected static string $resource = InboxTemplateResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

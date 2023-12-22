<?php

namespace App\Filament\Admin\Resources\InboxTemplateResource\Pages;

use App\Filament\Admin\Resources\InboxTemplateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInboxTemplates extends ListRecords
{
    protected static string $resource = InboxTemplateResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

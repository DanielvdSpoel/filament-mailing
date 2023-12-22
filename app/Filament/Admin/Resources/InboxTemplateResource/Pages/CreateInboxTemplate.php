<?php

namespace App\Filament\Admin\Resources\InboxTemplateResource\Pages;

use App\Filament\Admin\Resources\InboxTemplateResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInboxTemplate extends CreateRecord
{
    protected static string $resource = InboxTemplateResource::class;

    protected function getActions(): array
    {
        return [

        ];
    }
}

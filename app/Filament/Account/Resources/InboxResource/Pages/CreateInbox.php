<?php

namespace App\Filament\Account\Resources\InboxResource\Pages;

use App\Filament\Account\Resources\InboxResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInbox extends CreateRecord
{
    protected static string $resource = InboxResource::class;
}

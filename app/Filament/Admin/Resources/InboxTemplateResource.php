<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Resources\InboxTemplateResource\Pages;
use App\Models\InboxTemplate;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InboxTemplateResource extends Resource
{
    protected static ?string $model = InboxTemplate::class;

    protected static ?string $slug = 'inbox-templates';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name'),

            TextInput::make('imap_host'),

            TextInput::make('imap_port'),

            TextInput::make('imap_encryption'),

            TextInput::make('smtp_host'),

            TextInput::make('smtp_port'),

            TextInput::make('smtp_encryption'),

            Placeholder::make('created_at')
                ->label('Created Date')
                ->content(fn(?InboxTemplate $record): string => $record?->created_at?->diffForHumans() ?? '-'),

            Placeholder::make('updated_at')
                ->label('Last Modified Date')
                ->content(fn(?InboxTemplate $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')
                ->searchable()
                ->sortable(),

            TextColumn::make('imap_host'),

            TextColumn::make('imap_port'),

            TextColumn::make('imap_encryption'),

            TextColumn::make('smtp_host'),

            TextColumn::make('smtp_port'),

            TextColumn::make('smtp_encryption'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Admin\Resources\InboxTemplateResource\Pages\ListInboxTemplates::route('/'),
            'create' => \App\Filament\Admin\Resources\InboxTemplateResource\Pages\CreateInboxTemplate::route('/create'),
            'edit' => \App\Filament\Admin\Resources\InboxTemplateResource\Pages\EditInboxTemplate::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}

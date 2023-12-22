<?php

namespace App\Filament\Account\Resources;

use App\Filament\Account\Resources\InboxResource\Pages;
use App\Filament\Account\Resources\InboxResource\RelationManagers;
use App\Models\Inbox;
use App\Models\InboxTemplate;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InboxResource extends Resource
{
    protected static ?string $model = Inbox::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\TextInput::make('name')
                        ->autofocus()
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    Forms\Components\Select::make('template_id')
                        ->relationship('template', 'name')
                        ->native(false)
                        ->live()
                ])->columns(),

                Forms\Components\Section::make('Credentials')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('username')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->required()
                            ->maxLength(255)
                            ->type('password'),
                    ])->columns(2),

                Forms\Components\Section::make('IMAP information')
                    ->schema([
                        Forms\Components\TextInput::make('imap_host')
                            ->required(fn(Forms\Get $get) => $get('template_id') == null || InboxTemplate::find($get('template_id'))->imap_host == null)
                            ->placeholder(fn(Forms\Get $get) => $get('template_id') == null ? 'imap.example.com' : InboxTemplate::find($get('template_id'))->imap_host)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('imap_port')
                            ->required(fn(Forms\Get $get) => $get('template_id') == null || InboxTemplate::find($get('template_id'))->imap_port == null)
                            ->placeholder(fn(Forms\Get $get) => $get('template_id') == null ? '993' : InboxTemplate::find($get('template_id'))->imap_port)
                            ->type('number'),
                        Forms\Components\Select::make('imap_encryption')
                            ->required(fn(Forms\Get $get) => $get('template_id') == null || InboxTemplate::find($get('template_id'))->imap_encryption == null)
                            ->placeholder(fn(Forms\Get $get) => $get('template_id') == null ? 'SSL' : InboxTemplate::find($get('template_id'))->imap_encryption)
                            ->native(false)
                            ->options([
                                'none' => 'None',
                                'ssl' => 'SSL',
                                'tls' => 'TLS',
                            ]),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
                Forms\Components\Section::make('SMTP information')
                    ->schema([
                        Forms\Components\TextInput::make('smtp_host')
                            ->required(fn(Forms\Get $get) => $get('template_id') == null || InboxTemplate::find($get('template_id'))->smtp_host == null)
                            ->placeholder(fn(Forms\Get $get) => $get('template_id') == null ? 'smtp.example.com' : InboxTemplate::find($get('template_id'))->smtp_host)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('smtp_port')
                            ->required(fn(Forms\Get $get) => $get('template_id') == null || InboxTemplate::find($get('template_id'))->smtp_port == null)
                            ->placeholder(fn(Forms\Get $get) => $get('template_id') == null ? '465' : InboxTemplate::find($get('template_id'))->smtp_port)
                            ->type('number'),
                        Forms\Components\Select::make('smtp_encryption')
                            ->required(fn(Forms\Get $get) => $get('template_id') == null || InboxTemplate::find($get('template_id'))->smtp_encryption == null)
                            ->placeholder(fn(Forms\Get $get) => $get('template_id') == null ? 'SSL' : InboxTemplate::find($get('template_id'))->smtp_encryption)
                            ->native(false)
                            ->options([
                                'none' => 'None',
                                'ssl' => 'SSL',
                                'tls' => 'TLS',
                            ]),
                    ])                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('template.name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInboxes::route('/'),
            'create' => Pages\CreateInbox::route('/create'),
            'edit' => Pages\EditInbox::route('/{record}/edit'),
            'view' => Pages\ViewInbox::route('/{record}'),
        ];
    }
}

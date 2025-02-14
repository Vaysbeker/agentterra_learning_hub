<?php

namespace App\Filament\Resources;

use App\Models\Client;
use App\Filament\Resources\ClientResource\Pages;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Support\Facades\Hash;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class; // ✅ Работаем с таблицей "clients"
    protected static ?string $navigationLabel = 'Клиенты';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('ФИО')
                ->required(),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required(),

            TextInput::make('phone')
                ->label('Телефон')
                ->tel(),

            TextInput::make('password')
                ->label('Пароль')
                ->password()
                ->required(fn ($record) => !$record)
                ->dehydrated(fn ($state) => filled($state))
                ->afterStateUpdated(fn ($state, callable $set) =>
                $set('password', filled($state) ? Hash::make($state) : null) // ✅ Хэшируем только если пароль введён
                ),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('name')->label('ФИО')->searchable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('phone')->label('Телефон')->searchable(),
                TextColumn::make('created_at')->label('Дата регистрации')->sortable()
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->format('d.m.Y H:i')),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}


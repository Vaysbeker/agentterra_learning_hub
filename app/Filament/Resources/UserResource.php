<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Forms;
use Filament\Tables;
use Spatie\Permission\Models\Role;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\UserResource\Pages;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationLabel = 'Пользователи';
    protected static ?string $navigationGroup = 'База';
    protected static ?string $navigationIcon = 'heroicon-o-users';



    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('name')->label('ФИО')->required(),
            TextInput::make('city')->label('Город'),
            TextInput::make('phone')->label('Телефон')->tel(),
            TextInput::make('email')->label('Email')->email()->required(),

            Select::make('roles')
                ->label('Роль')
                ->multiple()
                ->relationship('roles', 'name') // ✅ Связываем с таблицей ролей
                ->preload(),

            TextInput::make('password')
                ->label('Пароль')
                ->password()
                ->nullable()
                ->dehydrated(false),
        ]);
    }


    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('name')->label('ФИО')->searchable(),
                TextColumn::make('city')->label('Город')->searchable(),
                TextColumn::make('phone')->label('Телефон')->searchable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('roles.name')->label('Роли')->sortable()->badge(),

                TextColumn::make('last_login_at')
                    ->label('Дата последнего визита')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state ? \Carbon\Carbon::parse($state)->format('d.m.Y H:i') : 'Нет данных'),
                TextColumn::make('created_at')
                    ->label('Дата регистрации')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->format('d.m.Y H:i')),

            ])
            ->filters([

                SelectFilter::make('roles')
                    ->label('Фильтр по ролям')
                    ->relationship('roles', 'name'),
            ])

            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

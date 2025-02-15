<?php

namespace App\Filament\Resources;

use Spatie\Permission\Models\Permission;
use App\Filament\Resources\PermissionResource\Pages;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\MultiSelect;
use Spatie\Permission\Models\Role;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;
    protected static ?string $navigationLabel = 'Доступы';
    protected static ?string $navigationGroup = 'База';
    protected static ?string $navigationParentItem = 'Пользователи';

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Название доступа')
                ->required()
                ->unique(ignoreRecord: true),

            MultiSelect::make('roles')
                ->label('Роли')
                ->relationship('roles', 'name') // ✅ Позволяет назначать права ролям
                ->preload(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('name')->label('Название')->sortable()->searchable(),
                TextColumn::make('roles.name')
                    ->label('Назначенные роли')
                    ->badge()
                    ->sortable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can('edit_permissions');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('edit_permissions');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit_permissions');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('edit_permissions');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }
}


<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use Spatie\Permission\Models\Role;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;
    protected static ?string $navigationLabel = 'Роли';
    protected static ?string $navigationGroup = 'База';
    protected static ?string $navigationParentItem = 'Пользователи';

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Название роли')
                ->required()
                ->unique(ignoreRecord: true),

            MultiSelect::make('permissions')
                ->label('Доступы')
                ->relationship('permissions', 'name') // ✅ Позволяет назначать доступы ролям
                ->preload(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('name')->label('Название')->sortable()->searchable(),
                TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
    public static function canViewAny(): bool
    {
        return auth()->user()->can('edit_roles');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('edit_roles');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit_roles');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('edit_roles');
    }
}

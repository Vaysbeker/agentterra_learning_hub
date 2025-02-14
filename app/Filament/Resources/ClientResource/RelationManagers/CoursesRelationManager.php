<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use App\Models\Course;
use App\Models\CourseBatch;
use Carbon\Carbon;

class CoursesRelationManager extends RelationManager
{
    protected static string $relationship = 'courses';
    protected static ?string $title = 'Обучение';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Название курса')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('pivot.course_batch_id') // ✅ Показываем поток
                ->label('Поток курса')
                    ->formatStateUsing(fn ($state) =>
                        CourseBatch::find($state)?->name ?? 'Без потока'),

                Tables\Columns\TextColumn::make('pivot.course_batch_id') // ✅ Показываем дату начала
                ->label('Дата начала')
                    ->formatStateUsing(fn ($state) =>
                    $state ? (CourseBatch::find($state)?->start_date ? Carbon::parse(CourseBatch::find($state)->start_date)->format('d.m.Y') : '—') : '—'),

                Tables\Columns\TextColumn::make('pivot.course_batch_id') // ✅ Показываем дату окончания
                ->label('Дата окончания')
                    ->formatStateUsing(fn ($state) =>
                    $state ? (CourseBatch::find($state)?->end_date ? Carbon::parse(CourseBatch::find($state)->end_date)->format('d.m.Y') : '—') : '—'),
            ])
            ->filters([]);
    }
}

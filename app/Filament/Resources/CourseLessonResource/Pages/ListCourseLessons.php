<?php

namespace App\Filament\Resources\CourseLessonResource\Pages;

use App\Filament\Resources\CourseLessonResource;
use App\Filament\Widgets\CourseLessonStatsOverviewWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;


class ListCourseLessons extends ListRecords
{
    protected static string $resource = CourseLessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    protected function getHeaderWidgets(): array
    {
        return [
            CourseLessonStatsOverviewWidget::class, // ✅ Используем отдельный класс
        ];
    }

}

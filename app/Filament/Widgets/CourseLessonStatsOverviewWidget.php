<?php
namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\CourseLesson;

class CourseLessonStatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Всего уроков', CourseLesson::count())
                ->description('Количество уроков в системе')
                ->icon('heroicon-o-academic-cap'),
        ];
    }
}

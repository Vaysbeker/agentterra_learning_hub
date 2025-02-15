<?php

namespace App\Filament\Resources\TestAnswerResource\Pages;

use App\Filament\Resources\TestAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTestAnswer extends CreateRecord
{
    protected static string $resource = TestAnswerResource::class;
}

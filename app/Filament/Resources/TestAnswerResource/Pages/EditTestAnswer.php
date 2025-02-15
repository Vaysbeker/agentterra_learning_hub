<?php

namespace App\Filament\Resources\TestAnswerResource\Pages;

use App\Filament\Resources\TestAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTestAnswer extends EditRecord
{
    protected static string $resource = TestAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

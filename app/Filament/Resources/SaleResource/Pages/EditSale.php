<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use App\Models\Client;
use App\Models\Course;
use App\Models\CourseBatch;

class EditSale extends ListRecords
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Назад')
                ->url(fn () => SaleResource::getUrl('index'))
                ->icon('heroicon-o-arrow-left'),
        ];
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(Sale::query()) // ✅ Загружаем данные из модели Sale
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\SelectColumn::make('client_id')
                    ->label('Клиент')
                    ->options(Client::pluck('name', 'id'))
                    ->searchable(),

                Tables\Columns\SelectColumn::make('course_id')
                    ->label('Курс')
                    ->options(Course::pluck('title', 'id'))
                    ->searchable()
                    ->rules(['required']),

                Tables\Columns\SelectColumn::make('course_batch_id')
                    ->label('Поток')
                    ->options(fn () => CourseBatch::pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('Без потока'),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Сумма')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sale_date')
                    ->label('Дата продажи')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Редактировать')
                    ->modalHeading('Редактировать продажу')
                    ->form([
                        Tables\Columns\SelectColumn::make('client_id')
                            ->label('Клиент')
                            ->options(Client::pluck('name', 'id'))
                            ->searchable(),

                        Tables\Columns\SelectColumn::make('course_id')
                            ->label('Курс')
                            ->options(Course::pluck('title', 'id'))
                            ->searchable()
                            ->rules(['required']),

                        Tables\Columns\SelectColumn::make('course_batch_id')
                            ->label('Поток')
                            ->options(fn () => CourseBatch::pluck('name', 'id'))
                            ->searchable()
                            ->placeholder('Без потока'),

                        Tables\Columns\TextColumn::make('amount')
                            ->label('Сумма'),

                        Tables\Columns\TextColumn::make('sale_date')
                            ->label('Дата продажи'),
                    ])
                    ->modalSubmitActionLabel('Сохранить'),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
        return [
            'sales' => [
                [
                    'id' => $data['id'],
                    'client_id' => $data['client_id'],
                    'course_id' => $data['course_id'],
                    'course_batch_id' => $data['course_batch_id'] ?? null,
                    'amount' => $data['amount'],
                    'sale_date' => $data['sale_date'],
                ],
            ],
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if (!isset($data['sales']) || empty($data['sales'])) {
            throw new \Exception("Добавьте хотя бы одну продажу.");
        }

        $saleData = $data['sales'][0]; // Так как это единичная продажа

        $record->update([
            'client_id' => $saleData['client_id'],
            'course_id' => $saleData['course_id'],
            'course_batch_id' => array_key_exists('course_batch_id', $saleData) ? $saleData['course_batch_id'] : null, // ✅ Исправлено
            'amount' => $saleData['amount'],
            'sale_date' => $saleData['sale_date'],
        ]);

        return $record;
    }
}

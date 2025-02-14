<?php
namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use App\Models\Sale;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use App\Models\Client;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use App\Models\CourseBatch;
use Illuminate\Support\Carbon;

class CreateSale extends CreateRecord
{
    protected static string $resource = SaleResource::class;

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('id')
                ->label('№№ продажи')
                ->default(fn () => \App\Models\Sale::max('id') + 1)
                ->disabled()
                ->required(),

            Forms\Components\DatePicker::make('sale_date')
                ->label('Дата продажи')
                ->default(Carbon::now())
                ->required(),

            Forms\Components\Repeater::make('sale_items')
                ->label('Добавить покупателей')
                ->default([['client_id' => null, 'course_id' => null, 'price' => null]]) // ✅ Добавляем пустую строку при клике
                ->schema([
                    Forms\Components\Select::make('client_id')
                        ->label('ФИО клиента')
                        ->options(Client::pluck('name', 'id'))
                        ->searchable()
                        ->nullable(), // ✅ Разрешаем пустое значение при добавлении

                    Forms\Components\Select::make('course_id')
                        ->label('Курс')
                        ->options(Course::pluck('title', 'id'))
                        ->searchable()
                        ->nullable(),

                    Forms\Components\TextInput::make('price')
                        ->label('Цена')
                        ->numeric()
                        ->nullable(), // ✅ Разрешаем пустое значение при добавлении
                ])
                ->reorderable()
                ->addable()
                ->deletable(),

            Forms\Components\TextInput::make('total_amount')
                ->label('ИТОГО')
                ->disabled()
                ->afterStateUpdated(fn ($state, callable $set, $context) =>
                $set('total_amount', collect($context['sale_items'] ?? [])->sum(fn ($item) => $item['price'] ?? 0))
                ),
        ]);
    }

    protected function handleRecordCreation(array $data): Model
    {
        // ✅ Переносим `client_id` и `course_id` из `sale_items` в корневой уровень
        if (!empty($data['sale_items']) && is_array($data['sale_items'])) {
            $firstItem = $data['sale_items'][0] ?? null;

            if ($firstItem && isset($firstItem['client_id'], $firstItem['course_id'])) {
                $data['client_id'] = (int) $firstItem['client_id'];
                $data['course_id'] = (int) $firstItem['course_id'];
            } else {
                throw new \Exception('ФИО клиента и курс обязательны.');
            }
        } else {
            throw new \Exception('ФИО клиента и курс обязательны.');
        }

        // ✅ Проверяем, что `client_id` и `course_id` присутствуют перед сохранением

        // ✅ Сохраняем продажу в базу
        return Sale::create($data);
    }



    public function getTitle(): string
    {
        $id = $this->form->getState()['id'] ?? null;
        $date = $this->form->getState()['sale_date'] ?? Carbon::now()->format('d.m.Y');

        return $id ? "Продажа №{$id} / {$date}" : "Создание продажи";
    }

}

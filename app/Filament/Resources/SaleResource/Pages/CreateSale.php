<?php
namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use App\Models\Client;
use App\Models\Course;
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
                ->required()
                ->default(fn () => \App\Models\Sale::max('id') + 1)
                ->disabled(),

            Forms\Components\DatePicker::make('sale_date')
                ->label('Дата продажи')
                ->default(Carbon::now())
                ->required(),

            Forms\Components\Repeater::make('sale_items')
                ->label('Добавить покупателей')
                ->default([]) // ✅ Гарантируем, что `sale_items` всегда массив
                ->schema([
                    Forms\Components\Select::make('client_id')
                        ->label('ФИО клиента')
                        ->options(Client::pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->validationMessages([
                            'required' => 'ФИО клиента обязательно.',
                        ]), // ✅ Сообщение об ошибке

                    Forms\Components\Select::make('course_id')
                        ->label('Курс')
                        ->options(Course::pluck('title', 'id'))
                        ->searchable()
                        ->required()
                        ->validationMessages([
                            'required' => 'Выберите курс.',
                        ]), // ✅ Сообщение об ошибке

                    Forms\Components\Select::make('course_batch_id')
                        ->label('Поток / Без потока')
                        ->options(fn () => CourseBatch::pluck('name', 'id'))
                        ->searchable()
                        ->nullable(),

                    Forms\Components\TextInput::make('price')
                        ->label('Цена')
                        ->numeric()
                        ->required()
                        ->validationMessages([
                            'required' => 'Укажите цену.',
                        ]), // ✅ Сообщение об ошибке
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

    public function getTitle(): string
    {
        $id = $this->form->getState()['id'] ?? null;
        $date = $this->form->getState()['sale_date'] ?? Carbon::now()->format('d.m.Y');

        return $id ? "Продажа №{$id} / {$date}" : "Создание продажи";
    }
}

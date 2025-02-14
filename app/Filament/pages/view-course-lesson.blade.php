@extends('filament::layouts.app')

@section('content')

    <div class="mx-auto max-w-3xl p-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-bold mb-4">{{ $record->title }}</h1>

        @foreach ($record->content as $block)
            <div class="mb-6">
                @if ($block['type'] === 'text')
                    <p class="text-gray-700">{{ $block['text'] }}</p>
                @elseif ($block['type'] === 'video')
                    <iframe class="w-full h-64" src="{{ $block['video_url'] }}" allowfullscreen></iframe>
                @elseif ($block['type'] === 'audio')
                    <audio controls class="w-full">
                        <source src="{{ $block['audio_url'] }}" type="audio/mpeg">
                        Ваш браузер не поддерживает аудио.
                    </audio>
                @elseif ($block['type'] === 'file')
                    <a href="{{ $block['file_url'] }}" target="_blank" class="text-blue-500 underline">Скачать файл</a>
                @endif
            </div>
        @endforeach

        <a href="{{ \App\Filament\Resources\CourseLessonResource::getUrl('index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
            ← Назад
        </a>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <h2>Шаг 1: Проверка системы</h2>
    <ul>
        @foreach($requirements as $key => $status)
            <li>{{ $key }}: {!! $status ? '✅ OK' : '❌ Ошибка' !!}</li>
        @endforeach
    </ul>
    <a href="{{ route('install.step2') }}">Далее</a>
@endsection

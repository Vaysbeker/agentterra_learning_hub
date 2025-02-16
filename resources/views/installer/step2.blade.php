@extends('layouts.app')

@section('content')
    <h2>Шаг 2: Настройка базы данных и администратора</h2>

    <form action="{{ route('install.process') }}" method="POST">
        @csrf

        <h3>Данные базы данных</h3>
        <label>DB Host</label>
        <input type="text" name="db_host" required value="127.0.0.1">

        <label>DB Name</label>
        <input type="text" name="db_name" required>

        <label>DB User</label>
        <input type="text" name="db_user" required>

        <label>DB Password</label>
        <input type="password" name="db_pass">

        <h3>Данные администратора</h3>
        <label>Имя администратора</label>
        <input type="text" name="admin_name" required>

        <label>Email администратора</label>
        <input type="email" name="admin_email" required>

        <label>Пароль</label>
        <input type="password" name="admin_password" required>

        <button type="submit">Установить</button>
    </form>
@endsection

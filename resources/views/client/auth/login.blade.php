<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в систему</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Вход в систему</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('client.login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" required
                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700">Пароль</label>
                <input type="password" id="password" name="password" required
                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <button type="submit"
                    class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 transition">
                Войти
            </button>
        </form>
    </div>
</div>
</body>
</html>

<template>
    <div class="flex h-screen bg-gray-100">
        <aside class="w-64 bg-white shadow-md p-4">
            <h2 class="text-lg font-bold">Клиентский кабинет</h2>
            <nav class="mt-4">
                <ul>
                    <li><router-link to="/dashboard">📚 Мои курсы</router-link></li>
                    <li><router-link to="/progress">📊 Прогресс</router-link></li>
                    <li><router-link to="/support">💬 Поддержка</router-link></li>
                </ul>
            </nav>
        </aside>
        <main class="flex-1 p-6">
            <router-view></router-view>
        </main>
    </div>
</template>

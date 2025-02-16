<script setup>
import { ref } from 'vue-router';

const links = [
    { name: 'Главная', path: '/' },
    { name: 'Курсы', path: '/courses' },
    { name: 'Мои покупки', path: '/purchases' },
    { name: 'Тестирование', path: '/tests' },
    { name: 'Профиль', path: '/profile' },
];
</script>

<template>
    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Agentterra Learning Hub</h1>
            <ul class="flex space-x-4">
                <li v-for="link in links" :key="link.path">
                    <router-link :to="link.path" class="hover:underline">
                        {{ link.name }}
                    </router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>

<style scoped>
a {
    text-decoration: none;
}
</style>

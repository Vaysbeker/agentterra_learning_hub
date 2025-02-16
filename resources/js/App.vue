<script setup>
import { ref } from 'vue';
import { RouterView } from 'vue-router';
import Navbar from './client-dashboard/src/components/Navbar.vue'; // ✅ Проверить правильность пути

const title = ref('Добро пожаловать');
</script>

<template>
    <div>
        <Navbar />
        <main class="container mx-auto p-4">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ title }}</h1>
            <RouterView />
        </main>
    </div>
</template>

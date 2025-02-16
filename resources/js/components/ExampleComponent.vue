<template>
    <div>
        <h2>Пример компонента Vue</h2>
        <p>{{ message }}</p>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const message = ref('Привет, Vue 3!');
</script>

<style scoped>
h2 {
    color: blue;
}
</style>

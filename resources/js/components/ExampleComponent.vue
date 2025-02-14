<template>
    <div>
        <h2 class="text-lg font-bold">Это компонент Vue!</h2>
        <button @click="increment" class="px-4 py-2 bg-blue-500 text-white rounded">
            Кликнуто: {{ count }}
        </button>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const count = ref(0);

const increment = () => {
    count.value++;
};
</script>

<!-- resources/js/client-dashboard/src/components/HelloWorld.vue -->
<template>
    <div>
        <h2>{{ msg }}</h2>
    </div>
</template>

<script setup>
defineProps(['msg']);
</script>

<style scoped>
h2 {
    color: green;
}
</style>

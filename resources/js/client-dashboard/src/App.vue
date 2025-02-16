<template>
    <div id="app">
        <Navbar />
        <Sidebar />
        <router-view></router-view>
    </div>
</template>

<script setup>
import Navbar from './components/Navbar.vue';
import Sidebar from './components/Sidebar.vue';
</script>

<style>
body {
    font-family: Arial, sans-serif;
}
</style>

import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'], // ✅ Указываем главный JS-файл
            refresh: true, // ✅ Включаем авто-обновление
        }),
        vue() // ✅ Используем Vue-плагин
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'), // ✅ Указываем alias для удобного импорта
        },
    },
    server: {
        host: 'localhost',
        port: 5178,
        strictPort: true,
    },
    build: {
        outDir: 'public/build',
        emptyOutDir: true,
    }
});

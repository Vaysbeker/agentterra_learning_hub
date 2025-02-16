import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [vue()],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
    server: {
        host: 'localhost',
        port: 5173,
        strictPort: true,
    },

    build: {
        outDir: 'public/build', // 📌 Директория сборки
        emptyOutDir: true,
}
});

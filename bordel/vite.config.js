import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/app.css',
                'resources/css/order_id.css',
                'resources/js/order_id.js',
                'resources/js/order_index.js',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});

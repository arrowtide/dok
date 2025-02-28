import {defineConfig} from 'vite';
import tailwindcss from '@tailwindcss/vite'
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/site.css', 
                'resources/js/index.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});

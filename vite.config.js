import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/guest/login.css',
                'resources/js/auth/data-entry.js',
                'resources/css/auth/data-entry.css',
                'resources/css/auth/records.css',
                'resources/js/auth/records.js',
                'resources/css/auth/respondents.css',
                'resources/js/auth/respondents.js',
                'resources/css/auth/dashboard.css',
                'resources/js/auth/dashboard.js',
                'resources/js/auth/users-list.js',
            ],
            refresh: true,
        }),
    ],
});



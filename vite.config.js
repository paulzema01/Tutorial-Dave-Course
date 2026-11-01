import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                // Bootstrap 5.3's Sass triggers Dart Sass deprecation notices
                // (@import, global functions). Hide those coming from node_modules,
                // and the @import notice in resources/scss/bootstrap.scss.
                quietDeps: true,
                silenceDeprecations: ['import'],
            },
        },
    },
});

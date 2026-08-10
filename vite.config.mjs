import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';
import ui from '@nuxt/ui/vite';
import { NuxtIconBundle } from '@nuxt/icon/vite';
import path from 'path';

const appOrigin =
    process.env.APP_URL ||
    `http://localhost:${process.env.FINANACE_HTTP_PORT || 8000}`;

const viteOrigin =
    process.env.VITE_DEV_SERVER_URL ||
    `http://localhost:${process.env.FINANACE_VITE_PORT || 5173}`;

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        origin: viteOrigin,

        cors: {
            origin: appOrigin,
        },

        hmr: {
            host: 'localhost',
            port: Number(process.env.FINANACE_VITE_PORT || 5173),
            protocol: 'ws',
        },
    },

    resolve: {
        dedupe: ['vue', 'vue-router'],
    },

    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            refresh: true,
        }),

        vue({
            template: {
                compilerOptions: {
                    whitespace: 'preserve',
                },

                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),

        ui({
            prefix: 'Nuxt',
            colorMode: false,
            ui: {
                colors: {
                    primary: 'zinc',
                    neutral: 'slate',
                },
            },
        }),

        NuxtIconBundle({
            scan: {
                globInclude: ['resources/js/**/*.{vue,ts,js}'],
            },
        }),

        tailwindcss({
            config: path.resolve(__dirname, 'tailwind.config.js'),
        }),
    ],
});
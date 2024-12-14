/// <reference types="vitest" />
import { defineConfig } from "vite";
import path from "path";
import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/assets/js/app.ts",
                "resources/assets/js/remote/app.ts",
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: "vue/dist/vue.esm-bundler.js",
            "@": path.resolve(__dirname, "./resources/assets/js"),
            "@modules": path.resolve(__dirname, "./node_modules"),
        },
    },
    test: {
        environment: 'jsdom',
        setupFiles: path.resolve(__dirname, "./resources/assets/js/__tests__/setup.ts")
    }
});

import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import * as path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/sass/app.scss", "resources/ts/app.ts"],
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
            "@": path.resolve(__dirname, "resources/ts"),
            "@components": path.resolve(__dirname, "resources/ts/components"),
            "@views": path.resolve(__dirname, "resources/ts/views"),
            "@utils": path.resolve(__dirname, "resources/ts/utils"),
            "@type": path.resolve(__dirname, "resources/ts/type"),
        },
    },
    server: {
        hmr: {
            host: "localhost",
        },
    },
});

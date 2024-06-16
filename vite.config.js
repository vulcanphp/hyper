import { fileURLToPath, URL } from 'node:url'
import { defineConfig, splitVendorChunkPlugin } from 'vite'
import liveReload from 'vite-plugin-live-reload'
import path from 'path'

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [
        liveReload([
            __dirname + './app/templates/**/*.php',
        ]),
        splitVendorChunkPlugin()
    ],
    base: process.env.NODE_ENV === "production" ? '/public/resources/build/' : '/public/resources/',
    root: './public/resources',
    server: {
        strictPort: true,
        port: 5133
    },
    build: {
        outDir: './build',
        emptyOutDir: true,
        manifest: true,
        rollupOptions: {
            input: path.resolve(__dirname, './public/resources/app.js'),
        }
    },
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./public/resources', import.meta.url))
        }
    }
})
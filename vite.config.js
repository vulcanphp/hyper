import { fileURLToPath, URL } from 'node:url'
import { defineConfig, splitVendorChunkPlugin } from 'vite'
import path from 'path'

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [
        splitVendorChunkPlugin()
    ],
    base: process.env.NODE_ENV === "production" ? '/resources/build/' : '/resources/',
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
            '@': fileURLToPath(new URL('./resources', import.meta.url))
        }
    }
})

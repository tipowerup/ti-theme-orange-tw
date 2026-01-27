import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/src/css/app.css',
                'resources/src/js/app.js'
            ],
            publicDirectory: 'public',
            buildDirectory: 'build',
            refresh: true,
        }),
    ],
    build: {
        manifest: 'manifest.json',
        outDir: 'public/build',
        rollupOptions: {
            output: {
                entryFileNames: 'js/[name]-[hash].js',
                chunkFileNames: 'js/[name]-[hash].js',
                assetFileNames: (assetInfo) => {
                    const name = assetInfo.names?.[0] ?? assetInfo.name ?? '';
                    if (name.endsWith('.css')) {
                        return 'css/[name]-[hash][extname]';
                    }
                    return 'assets/[name]-[hash][extname]';
                },
                manualChunks: (id) => {
                    if (id.includes('node_modules')) {
                        if (id.includes('alpinejs')) {
                            return 'alpine';
                        }
                        return 'vendor';
                    }
                },
            },
        },
    },
});

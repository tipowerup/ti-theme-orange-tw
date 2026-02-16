import { defineConfig } from 'vite';

export default defineConfig({
    publicDir: false,
    build: {
        outDir: 'public',
        emptyOutDir: false,
        rollupOptions: {
            input: {
                app: 'resources/src/js/app.js',
                styles: 'resources/src/css/app.css',
            },
            output: {
                entryFileNames: 'js/[name].js',
                chunkFileNames: 'js/[name].js',
                assetFileNames: (assetInfo) => {
                    const name = assetInfo.names?.[0] ?? assetInfo.name ?? '';
                    if (name.endsWith('.css') || name === 'styles.css') {
                        return 'css/app.css';
                    }
                    return 'assets/[name][extname]';
                },
            },
        },
    },
});

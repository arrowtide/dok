import {defineConfig, loadEnv} from 'vite'
import laravel from 'laravel-vite-plugin';

export default defineConfig(({mode}) => {
    const env = loadEnv(mode, process.cwd(), '')
    const isSecuredSite = env.APP_URL.startsWith('https://');
    const host = env.APP_URL.replace(/^https?:\/\//, '');


    console.log(host);

    return {
        plugins: [
            laravel({
                input: [
                    'resources/css/site.css',
                    'resources/js/index.js',
                ],
                detectTls: isSecuredSite ? host : false,
                refresh: true,
            })
        ],
    }
});

module.exports = {
    pages: {
        index: {
            template: 'public/index.html',
            entry: 'src/index.js',
            filename: 'index.html'
        }
    },
    chainWebpack: (config) => {
        // Make pages PHP files instead of HTML
        /*const pages = {
            index: 'index.php'
        };
        if (process.env.NODE_ENV === 'production') {
            for (let page in pages) {
                let pagePath = pages[page];
                config.plugin('html-' + page).tap((opts) => {
                    opts[0].filename = pagePath;
                    return opts;
                });
            }
        }*/
    },
    devServer: {
        disableHostCheck: true
    },
    pwa: {
        name: 'Quic Calc',
        themeColor: '#71c837',
        msTileColor: '#00a300',
        iconPaths: {
            favicon32: 'favicon-32x32.png',
            favicon16: 'favicon-16x16.png',
            appleTouchIcon: 'apple-touch-icon.png',
            maskIcon: 'safari-pinned-tab.svg',
            msTileImage: 'mstile-144x144.png'
        },
        manifestOptions: {
            "name": "Quic Calc",
            "short_name": "Quic Calc",
            "scope": "/",
            "start_url": "/",
            "description": "A Quick Calculator App",
            "icons": [
                {
                    "src": "/android-chrome-192x192.png",
                    "sizes": "192x192",
                    "type": "image/png"
                },
                {
                    "src": "/android-chrome-512x512.png",
                    "sizes": "512x512",
                    "type": "image/png"
                }
            ],
            "theme_color": "#71c837",
            "background_color": "#f3f3f3",
            "display": "standalone"
        },
        workboxPluginMode: 'GenerateSW',
        workboxOptions: {
            swDest: 'service-worker.js',
            cacheId: 'quic-calc',
            exclude: ['robots.txt', /\.map$/],
            cleanupOutdatedCaches: true,
            skipWaiting: true
        }
    }
};
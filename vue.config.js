module.exports = {
    pwa: {
        manifestOptions: {
            name: 'Quic Calc',
            short_name: 'Quic Calc'
        }
    },
    chainWebpack: (config) => {
        if (process.env.NODE_ENV === 'production') {
            config.plugin('html').tap((opts) => {
                opts[0].filename = 'index.php';
                return opts;
            });
        }
    }
};
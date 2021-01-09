const fs = require('fs');
const path = require('path');
const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');
const configFile = './dev-config.json';

const isProduction = process.env.NODE_ENV === 'production';

const devServer = () => {
  if (!fs.existsSync(configFile)) {
    return {};
  }

  const config = JSON.parse(fs.readFileSync(configFile));

  let http = process.argv.includes('--https') ? 'https' : 'http';
  const url = `${http}://${config.host}:${config.port}/`;

  let server = {
    host: config.host, // this is WP Hostname
    port: config.port,
    hot: true,
    writeToDisk: true,
    liveReload: false,
    overlay: true,
    // open: true,
    // openPage: 'wp/wp-admin/',
    public: url,
    // Allow access to WDS data from anywhere, including the standard non-proxied site URL
    headers: {
      'Access-Control-Allow-Origin': '*',
      'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, PATCH, OPTIONS',
      'Access-Control-Allow-Headers':
        'X-Requested-With, content-type, Authorization',
    },
  };

  return server;
};

module.exports = {
  ...defaultConfig,
  entry: {
    admin: './src/index.js',
  },
  output: {
    path: path.resolve(__dirname, 'dist'),
    filename: '[name].js',
    publicPath: '/wp-content/plugins/texty/dist/',
    // chunkFilename: 'chunks/[name].js',
    // jsonpFunction: 'dokanCloudWebpack'
  },
  resolve: {
    alias: {
      ...defaultConfig.resolve.alias,
      '@': path.resolve('./src/'),
    },
  },
  devServer: devServer(),
  plugins: [
    // remove the plugin, next insert our own logic
    ...defaultConfig.plugins.filter((plugin) => {
      // list of plugin we want to remove
      const removed = ['DependencyExtractionWebpackPlugin', 'LiveReloadPlugin'];

      // console.log(plugin.constructor.name + ': ' + exists);
      const exists = removed.indexOf(plugin.constructor.name) === -1;

      return exists;
    }),
    new DependencyExtractionWebpackPlugin({
      injectPolyfill: true,
      requestToExternal(request) {
        // remove WordPress externals, except...
        // api-fetch, because it sets the API fetching defaults
        if (request !== '@wordpress/api-fetch') {
          return '';
        }
      },
    }),
  ],
  optimization: {
    ...defaultConfig.optimization,
    splitChunks: {
      cacheGroups: {
        ...defaultConfig.optimization.splitChunks.cacheGroups,
        vendor: {
          test: /[\\/]node_modules[\\/]/,
          name: 'vendors',
          chunks: 'all',
        },
      },
    },
  },
};

const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
  mode: 'development',
  watch: true,
  entry: {
    'homepage' : './src/scss/homepage.scss',
  },
  performance: {
    maxEntrypointSize: 3000000,
    maxAssetSize: 1500000
  },
  output: {
    path: path.resolve(`${__dirname}/public/css`)
  },
  plugins: [
    new MiniCssExtractPlugin({
      // Options similar to the same options in webpackOptions.output
      // both options are optional
      filename: './[name].css'
    })
  ],
  module: {
    rules: [
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          'postcss-loader',
          'sass-loader'
        ]
      }
    ]
  }
};

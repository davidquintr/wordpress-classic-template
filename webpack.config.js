/**
 * Webpack build.
 *
 * One chunk, two outputs: dist/script.js (scripts/index.ts) and
 * dist/styles.css (styles/main.css).
 * css-loader leaves url() untouched: assets are served from the theme
 * folder, so their URLs stay stable and can be preloaded from PHP.
 * The CSS minifier runs in production only (npm run build); '...' keeps
 * webpack's default JS minifier.
 */

const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');

module.exports = {
  entry: ['./scripts/index.ts', './styles/main.css'],
  module: {
    rules: [
      {
        test: /\.tsx?$/,
        use: 'ts-loader',
        exclude: /node_modules/,
      },
      {
        test: /\.css$/i,
        use: [
          MiniCssExtractPlugin.loader,

          { loader: 'css-loader', options: { url: false } },
        ],
      },
    ],
  },
  resolve: {
    extensions: ['.tsx', '.ts', '.js'],
  },
  output: {
    filename: 'script.js',
    path: path.resolve(__dirname, 'dist'),
    clean: true,
  },
  plugins: [new MiniCssExtractPlugin({ filename: 'styles.css' })],
  optimization: {
    minimizer: ['...', new CssMinimizerPlugin()],
  },
};

const path = require('path')
const TerserPlugin = require('terser-webpack-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin')
const WebpackNotifierPlugin = require('webpack-notifier')

const isDevelopment = process.env.NODE_ENV === 'development'
const isProduction = process.env.NODE_ENV === 'production'
const ASSET_PATH = process.env.ASSET_PATH || '../dist/'

let config = {
    resolve: {
        modules: [
            path.resolve('./node_modules'),
            path.resolve('../../../public/node_modules')
        ]
    },
    mode: process.env.NODE_ENV,
    entry: {
        main: [
            // css before js
            './src/scss/style.scss',
            './src/js/index.js'
        ]
    },
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: '[name].js',
        publicPath: ASSET_PATH
    },
    watch: isDevelopment,
    watchOptions: {
        ignored: '/node_modules/'
    },
    devtool: 'source-map',
    /* Bug sourceMap css
    isDevelopment ? 'inline-cheap-source-map' : 'source-map',
    */
    module: {
        rules: [
            {
                enforce: 'pre',
                test: /\.m?js$/,
                exclude: /(node_modules|bower_components)/,
                use: [
                    {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env'],
                            plugins: ['@babel/plugin-syntax-dynamic-import']
                        }
                    },
                    {
                        loader: 'eslint-loader'
                    }
                ]
            },
            {
                test: /\.(css|scss)$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                        /* loader: isDevelopment ? 'style-loader' : MiniCssExtractPlugin.loader, */
                        options: {
                            sourceMap: true
                        }
                    },
                    {
                        loader: 'css-loader',
                        options: {
                            importLoaders: 1,
                            sourceMap: true
                        }
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            ident: 'postcss',
                            plugins: (loader) => [
                                require('autoprefixer')({
                                    overrideBrowserslist: ['last 2 versions', 'ie > 10']
                                })
                            ],
                            sourceMap: true
                        }
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: true,
                            includePaths: [
                                '../../../public/ipsum/admin/node_modules/'
                            ]
                        }
                    }
                ],
                exclude: /node_modules/
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: '[name].css',
            chunkFilename: '[id].css'
        }),
        new WebpackNotifierPlugin()
    ],
    optimization: {
        minimize: isProduction,
        minimizer: [
            new OptimizeCSSAssetsPlugin({
                cssProcessorOptions: {
                    map: {
                        inline: false,
                        annotation: true
                    }
                }
            }),
            new TerserPlugin({
                cache: true,
                parallel: true,
                sourceMap: true
            })
        ]
    }
}

module.exports = config

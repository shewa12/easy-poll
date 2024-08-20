const path = require('path');
const CopyPlugin = require('copy-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
var ZipPlugin = require('zip-webpack-plugin');
const pluginVersion = require('./package.json').version;
module.exports = (env) => {
    return {
        entry: { },
        output: {
            path: path.join(__dirname, 'build'),
            publicPath: '/build',
        },
        optimization: {
            minimizer: [new TerserPlugin({
              extractComments: false,
            })],
        },
        plugins: [
            new CopyPlugin({
                patterns: [
                    {
                        from: './**',
                        // default output path is build
                        //to: './build',
                        globOptions: {
                            dot: true,
                            gitignore: false,
                            ignore: [
                                "**/node_modules/**",
                                "**/tests/**",
                                "**/bin/**",
                                "**/vendor/bin/**",
                                "**/vendor/phpcompatibility/**",
                                "**/vendor/squizlabs/**",
                                "**/vendor/wp-coding-standards/**",
                                "**/*.json*",
                                "**/*.lock*",
                                "**/.travis.yml",
                                "**/.gitignore",
                                "**/.distignore",
                                "**/.editorconfig",
                                "**/*.dist*",
                                "**/*.zip*",
                                "**/*.md*",
                                "**/*.cache*",
                                "**/webpack.config.js",
                                "**/webpack.zip.js",
                                "**/assets/bundles/backend-style.min.js",
                                "**/assets/bundles/frontend-style.min.js",
                                "**/assets/bundles/common-style.min.js",
                                "**/assets/scripts/**",
                                "**/assets/scss/**",
                                "**/.git",
                                "**/.github/**"
                            ],
                        },
                    },
                    
                ],
            }),
            new ZipPlugin({
                path: '../',
                filename: `easy-poll.zip`,
                extension: 'zip',
                fileOptions: {
                    mtime: new Date(),
                    mode: 0o100664,
                    compress: true,
                    forceZip64Format: false,
                  },
            
                  // OPTIONAL: see https://github.com/thejoshwolfe/yazl#endoptions-finalsizecallback
                  zipOptions: {
                    forceZip64Format: false,
                },
            })
        ]
    };
};
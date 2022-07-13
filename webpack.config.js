const path = require("path");
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
module.exports = (env) => {
	return {
		mode: env.mode,
		entry: {
			common: "./assets/scripts/common.js",
			frontend: "./assets/scripts/frontend.js",
			backend: "./assets/scripts/backend.js",
            // css
            common: './assets/scss/common-style.scss',
            frontend: './assets/scss/frontend-style.scss',
            backend: './assets/scss/backend-style.scss',
		},
		plugins: [
            // Extract css from js & make it separate
            new MiniCssExtractPlugin({
              filename: '[name].min.css'
            })
        ],
        // Both js & css files will be stored inside the bundles dir
		output: {
			filename: `[name].min.js`,
			path: path.resolve(__dirname, "./assets/bundles"),
			clean: true,
		},
		module: {
			rules: [
                {
					test: /\.s[ac]ss$/i,
					exclude: /node_modules/,
					use: [
					  MiniCssExtractPlugin.loader,
					  "css-loader",
					  "sass-loader",
					],
                }
			],
		},
	};
};

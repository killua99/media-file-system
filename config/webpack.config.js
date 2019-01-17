'use strict'

const path = require( 'path' )

module.exports = {
	entry: () => './src',
	output: {
		path: path.resolve( __dirname, 'assets' ),
		filename: '[name].js',
	},
}

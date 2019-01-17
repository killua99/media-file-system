'use strict'

const path = require( 'path' )
const glob = require( 'glob' )
const env = process.env.NODE_ENV

function toObject ( paths ) {
	let ret = {}

	paths.forEach( function ( path ) {
		ret[ path.split( '/' ).slice( -1 )[ 0 ] ] = path
	} )

	return ret
}

module.exports = {
	mode: env || 'development',
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: 'babel-loader',
			},
		],
	},
	entry: toObject( glob.sync( path.resolve( __dirname, '../src' ) + '/**/*.js' ) ),
	output: {
		path: path.resolve( __dirname, '../assets/js' ),
		filename: '[name]',
	},
}

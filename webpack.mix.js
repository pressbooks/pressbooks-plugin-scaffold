let path = require( 'path' );
let mix = require( 'laravel-mix' );

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix

	.version()
	.options( { processCssUrls: false } )
	.setPublicPath( path.join( 'assets', 'dist' ) )
	.js( 'assets/scripts/pressbooks-plugin-scaffold.js', 'assets/dist/scripts/' )
	.sass( 'assets/styles/pressbooks-plugin-scaffold.scss', 'assets/dist/styles/' )
	.copyDirectory( 'assets/fonts', 'assets/dist/fonts' )
	.copyDirectory( 'assets/images', 'assets/dist/images' )

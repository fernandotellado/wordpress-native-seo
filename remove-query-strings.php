<?php
/**
 * Remove query strings from static resources
 *
 * Removes ?ver= parameters from CSS and JS file URLs.
 * This allows CDNs and proxy caches to cache them properly.
 *
 * Usage: Add to your theme's functions.php or as a mu-plugin.
 */
add_filter( 'script_loader_src', 'ayudawp_remove_query_strings', 15 );
add_filter( 'style_loader_src', 'ayudawp_remove_query_strings', 15 );

function ayudawp_remove_query_strings( $src ) {
	if ( strpos( $src, '?ver=' ) !== false ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}

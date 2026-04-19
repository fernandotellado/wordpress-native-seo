<?php
/**
 * Small but useful WordPress tweaks for SEO
 *
 * Three quick fixes in one file:
 * - Enable excerpts on pages (for meta descriptions)
 * - Disable self-pingbacks (unnecessary database entries)
 * - Generic login error message (security)
 *
 * Usage: Add to your theme's functions.php or as a mu-plugin.
 */

// Enable excerpt support for pages
add_post_type_support( 'page', 'excerpt' );

// Disable internal self-pingbacks
add_action( 'pre_ping', function( &$links ) {
	$home = get_option( 'home' );
	foreach ( $links as $l => $link ) {
		if ( 0 === strpos( $link, $home ) ) {
			unset( $links[ $l ] );
		}
	}
});

// Generic login error message (don't reveal if username or password was wrong)
add_filter( 'login_errors', function() {
	return __( 'Login data is not correct.', 'ayudawp-seo-tweaks' );
});

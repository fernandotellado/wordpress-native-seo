<?php
/**
 * Restrict REST API to authenticated users
 *
 * Prevents public access to the WordPress REST API, which
 * by default exposes usernames, post data, and site structure.
 * Visit /wp-json/wp/v2/users while logged out to see the problem.
 *
 * Usage: Add to your theme's functions.php or as a mu-plugin.
 */
add_filter( 'rest_authentication_errors', function( $result ) {
	if ( true === $result || is_wp_error( $result ) ) {
		return $result;
	}
	if ( ! is_user_logged_in() ) {
		return new WP_Error(
			'rest_not_logged_in',
			__( 'API access restricted to authenticated users.', 'ayudawp-seo-tweaks' ),
			array( 'status' => 401 )
		);
	}
	return $result;
});

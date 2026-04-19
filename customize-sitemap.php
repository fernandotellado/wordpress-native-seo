<?php
/**
 * Customize the native WordPress XML sitemap
 *
 * Removes tags, author archives, and (optionally) pages
 * from the sitemap. Uncomment/comment each filter as needed.
 *
 * Usage: Add to your theme's functions.php or as a mu-plugin.
 */

// Remove tags from the sitemap
add_filter( 'wp_sitemaps_taxonomies', function( $taxonomies ) {
	unset( $taxonomies['post_tag'] );
	return $taxonomies;
});

// Remove author archives from the sitemap
add_filter( 'wp_sitemaps_add_provider', function( $provider, $name ) {
	if ( 'users' === $name ) {
		return false;
	}
	return $provider;
}, 10, 2 );

// Uncomment to also remove pages from the sitemap
// add_filter( 'wp_sitemaps_post_types', function( $post_types ) {
// 	unset( $post_types['page'] );
// 	return $post_types;
// });

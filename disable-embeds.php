<?php
/**
 * Disable WordPress oEmbed/Embeds
 *
 * Removes the oEmbed REST route, discovery links, and host
 * JavaScript. Saves HTTP requests if you don't embed content
 * from or into other WordPress sites.
 *
 * Usage: Add to your theme's functions.php or as a mu-plugin.
 */
add_action( 'init', function() {
	remove_action( 'rest_api_init', 'wp_oembed_register_route' );
	remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
}, 9999 );

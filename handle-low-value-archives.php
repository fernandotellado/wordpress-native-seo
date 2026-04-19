<?php
/**
 * Handle low-value archives: redirects and noindex rules
 *
 * - Redirects author archives to homepage (single-author sites)
 * - Redirects date archives to homepage
 * - Adds noindex to search result pages
 * - Adds noindex to tag/category archives with 2 or fewer posts
 *
 * Comment out any section you don't need.
 *
 * Usage: Add to your theme's functions.php or as a mu-plugin.
 */

// Redirect author archives to homepage (301)
add_action( 'template_redirect', function() {
	if ( is_author() ) {
		wp_redirect( home_url(), 301 );
		exit;
	}
});

// Redirect date archives to homepage (301)
add_action( 'template_redirect', function() {
	if ( is_date() ) {
		wp_redirect( home_url(), 301 );
		exit;
	}
});

// Noindex search result pages
add_action( 'wp_head', function() {
	if ( is_search() ) {
		echo '<meta name="robots" content="noindex, nofollow">' . "\n";
	}
});

// Noindex thin taxonomy archives (2 or fewer posts)
add_action( 'wp_head', function() {
	if ( ( is_tag() || is_category() ) && get_queried_object()->count <= 2 ) {
		echo '<meta name="robots" content="noindex, follow">' . "\n";
	}
});

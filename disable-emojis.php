<?php
/**
 * Disable WordPress emoji scripts and styles
 *
 * WordPress loads a JavaScript file and inline styles for emoji
 * rendering on every page. If you don't use WordPress emoji,
 * this removes the overhead.
 *
 * Usage: Add to your theme's functions.php or as a mu-plugin.
 */
add_action( 'init', function() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
});

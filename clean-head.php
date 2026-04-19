<?php
/**
 * Clean unnecessary tags from WordPress <head>
 *
 * Removes: generator version, Windows Live Writer manifest,
 * Really Simple Discovery, shortlinks, REST API discovery,
 * comment feeds, and previous/next post links.
 *
 * Usage: Add to your theme's functions.php or as a mu-plugin.
 */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );

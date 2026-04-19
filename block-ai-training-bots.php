<?php
/**
 * Block AI training bots via the virtual robots.txt
 *
 * WordPress generates a virtual robots.txt accessible at /?robots=1
 * This filter adds rules to block AI training crawlers while keeping
 * search and citation bots (Googlebot, Bingbot, ChatGPT-User) allowed.
 *
 * Note: robots.txt is advisory, not mandatory. Well-behaved crawlers
 * respect it, but nothing technically prevents a bot from ignoring it.
 *
 * Usage: Add to your theme's functions.php or as a mu-plugin.
 */
add_filter( 'robots_txt', function( $output, $public ) {
	$output .= "\n";
	$output .= "# Block AI training bots\n";
	$output .= "User-agent: GPTBot\n";
	$output .= "Disallow: /\n\n";
	$output .= "User-agent: ClaudeBot\n";
	$output .= "Disallow: /\n\n";
	$output .= "User-agent: Google-Extended\n";
	$output .= "Disallow: /\n\n";
	$output .= "User-agent: CCBot\n";
	$output .= "Disallow: /\n\n";
	$output .= "User-agent: Bytespider\n";
	$output .= "Disallow: /\n";
	return $output;
}, 10, 2 );

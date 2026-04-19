<?php
/**
 * Plugin Name: WordPress Native SEO & GEO Tweaks
 * Description: A collection of native WordPress SEO and GEO optimizations. No SEO plugin needed. Customize by commenting out any section you don't need.
 * Version: 1.0.0
 * Author: Fernando Tellado
 * Author URI: https://ayudawp.com
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * INSTALLATION:
 * Place this file in wp-content/mu-plugins/ (create the folder if needed).
 * It loads automatically — no activation required.
 *
 * CUSTOMIZATION:
 * Comment out any section you don't need. Each section is independent.
 *
 * Based on the workshop "Do you really need an SEO/GEO plugin for WordPress?"
 * by Fernando Tellado at WordCamp Europe 2026.
 *
 * Full reference guide: https://github.com/fernandotellado/wordpress-native-seo-geo
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// =============================================================================
//
//  1. HEAD CLEANUP
//  Removes unnecessary tags from <head> that expose info and add no SEO value.
//
// =============================================================================

remove_action( 'wp_head', 'wp_generator' );                                    // WordPress version
remove_action( 'wp_head', 'wlwmanifest_link' );                                // Windows Live Writer
remove_action( 'wp_head', 'rsd_link' );                                        // Really Simple Discovery
remove_action( 'wp_head', 'wp_shortlink_wp_head' );                            // Shortlinks
remove_action( 'wp_head', 'rest_output_link_wp_head' );                        // REST API link
remove_action( 'wp_head', 'feed_links_extra', 3 );                             // Comment feeds
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );             // Prev/next links


// =============================================================================
//
//  2. DISABLE EMOJIS
//  Removes the emoji detection script and styles loaded on every page.
//
// =============================================================================

add_action( 'init', function() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
});


// =============================================================================
//
//  3. REMOVE QUERY STRINGS
//  Strips ?ver= from CSS and JS URLs so CDNs and proxies can cache them.
//
// =============================================================================

add_filter( 'script_loader_src', 'ayudawp_seo_remove_query_strings', 15 );
add_filter( 'style_loader_src', 'ayudawp_seo_remove_query_strings', 15 );

function ayudawp_seo_remove_query_strings( $src ) {
	if ( strpos( $src, '?ver=' ) !== false ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}


// =============================================================================
//
//  4. DISABLE oEMBED / EMBEDS
//  Removes the oEmbed REST route, discovery links, and host JavaScript.
//
// =============================================================================

add_action( 'init', function() {
	remove_action( 'rest_api_init', 'wp_oembed_register_route' );
	remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
}, 9999 );


// =============================================================================
//
//  5. RESTRICT REST API
//  Limits REST API access to authenticated users only.
//  Prevents public exposure of usernames, post data, and site structure.
//
// =============================================================================

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


// =============================================================================
//
//  6. SITEMAP CUSTOMIZATION
//  Removes tags and author archives from the native WordPress XML sitemap.
//  Uncomment the pages filter if you also want to exclude pages.
//
// =============================================================================

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


// =============================================================================
//
//  7. ROBOTS.TXT — BLOCK AI TRAINING BOTS
//  Adds rules to the virtual robots.txt to block bots that scrape content
//  for model training. Search and citation bots are NOT blocked.
//
// =============================================================================

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


// =============================================================================
//
//  8. AUTO META DESCRIPTION
//  Generates <meta name="description"> from native WordPress fields:
//  - Homepage: tagline (Settings → General)
//  - Posts/Pages: excerpt or trimmed content
//  - Category/Tag archives: term description
//  - Author archives: biographical info
//
// =============================================================================

add_action( 'wp_head', function() {
	$description = '';

	if ( is_front_page() || is_home() ) {
		$description = get_bloginfo( 'description' );

	} elseif ( is_singular() ) {
		global $post;
		$description = $post->post_excerpt;
		if ( empty( $description ) ) {
			$description = wp_trim_words( wp_strip_all_tags( $post->post_content ), 25, '...' );
		}

	} elseif ( is_category() || is_tag() || is_tax() ) {
		$description = term_description();

	} elseif ( is_author() ) {
		$description = get_the_author_meta( 'description' );
	}

	$description = esc_attr( wp_strip_all_tags( trim( $description ) ) );

	if ( ! empty( $description ) ) {
		echo '<meta name="description" content="' . $description . '">' . "\n";
	}
});


// =============================================================================
//
//  9. OPEN GRAPH AND TWITTER CARD TAGS
//  Generates og:title, og:description, og:image, og:url, plus Twitter Card
//  tags from standard WordPress fields (title, excerpt, featured image).
//
// =============================================================================

add_action( 'wp_head', function() {
	if ( is_singular() ) {
		global $post;
		$title       = esc_attr( get_the_title( $post ) );
		$description = esc_attr( $post->post_excerpt ?: wp_trim_words( wp_strip_all_tags( $post->post_content ), 25, '...' ) );
		$url         = esc_url( get_permalink( $post ) );
		$site_name   = esc_attr( get_bloginfo( 'name' ) );
		$locale      = esc_attr( get_locale() );

		echo '<meta property="og:title" content="' . $title . '">' . "\n";
		echo '<meta property="og:description" content="' . $description . '">' . "\n";
		echo '<meta property="og:url" content="' . $url . '">' . "\n";
		echo '<meta property="og:site_name" content="' . $site_name . '">' . "\n";
		echo '<meta property="og:locale" content="' . $locale . '">' . "\n";
		echo '<meta property="og:type" content="article">' . "\n";

		if ( has_post_thumbnail( $post ) ) {
			$img = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'large' );
			if ( $img ) {
				echo '<meta property="og:image" content="' . esc_url( $img[0] ) . '">' . "\n";
				echo '<meta property="og:image:width" content="' . intval( $img[1] ) . '">' . "\n";
				echo '<meta property="og:image:height" content="' . intval( $img[2] ) . '">' . "\n";
			}
		}

		echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
		echo '<meta name="twitter:title" content="' . $title . '">' . "\n";
		echo '<meta name="twitter:description" content="' . $description . '">' . "\n";
	}
});


// =============================================================================
//
//  10. ENABLE EXCERPTS ON PAGES
//  By default WordPress only supports excerpts on posts.
//
// =============================================================================

add_post_type_support( 'page', 'excerpt' );


// =============================================================================
//
//  11. DISABLE SELF-PINGBACKS
//  Prevents WordPress from pinging itself when you link to your own content.
//
// =============================================================================

add_action( 'pre_ping', function( &$links ) {
	$home = get_option( 'home' );
	foreach ( $links as $l => $link ) {
		if ( 0 === strpos( $link, $home ) ) {
			unset( $links[ $l ] );
		}
	}
});


// =============================================================================
//
//  12. REDIRECT LOW-VALUE ARCHIVES
//  Author and date archives often duplicate content.
//  Comment out if you have multiple authors or use date archives intentionally.
//
// =============================================================================

// Redirect author archives to homepage (single-author sites)
add_action( 'template_redirect', function() {
	if ( is_author() ) {
		wp_redirect( home_url(), 301 );
		exit;
	}
});

// Redirect date archives to homepage
add_action( 'template_redirect', function() {
	if ( is_date() ) {
		wp_redirect( home_url(), 301 );
		exit;
	}
});


// =============================================================================
//
//  13. NOINDEX RULES
//  Adds noindex to pages that shouldn't appear in search results.
//
// =============================================================================

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


// =============================================================================
//
//  14. GENERIC LOGIN ERROR MESSAGE
//  Prevents WordPress from revealing whether the username or password was wrong.
//
// =============================================================================

add_filter( 'login_errors', function() {
	return __( 'Login data is not correct.', 'ayudawp-seo-tweaks' );
});

<?php
/**
 * Auto meta description for all page types
 *
 * Generates <meta name="description"> from native WordPress fields:
 * - Homepage: tagline from Settings → General
 * - Posts/Pages: excerpt, or trimmed content if no excerpt
 * - Category/Tag/Custom taxonomy archives: term description
 * - Author archives: biographical info from user profile
 *
 * No SEO plugin needed. Just fill in the fields WordPress already provides.
 *
 * Usage: Add to your theme's functions.php or as a mu-plugin.
 */
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

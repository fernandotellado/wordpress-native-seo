<?php
/**
 * Open Graph and Twitter Card meta tags
 *
 * Generates og:title, og:description, og:image, og:url, og:type,
 * og:site_name, og:locale, and Twitter Card tags automatically
 * from standard WordPress fields (title, excerpt, featured image).
 *
 * For a more complete solution see:
 * https://github.com/fernandotellado/open-graph-tags-wordpress
 *
 * Usage: Add to your theme's functions.php or as a mu-plugin.
 */
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

		// Featured image as og:image
		if ( has_post_thumbnail( $post ) ) {
			$img = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'large' );
			if ( $img ) {
				echo '<meta property="og:image" content="' . esc_url( $img[0] ) . '">' . "\n";
				echo '<meta property="og:image:width" content="' . intval( $img[1] ) . '">' . "\n";
				echo '<meta property="og:image:height" content="' . intval( $img[2] ) . '">' . "\n";
			}
		}

		// Twitter Card
		echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
		echo '<meta name="twitter:title" content="' . $title . '">' . "\n";
		echo '<meta name="twitter:description" content="' . $description . '">' . "\n";
	}
});

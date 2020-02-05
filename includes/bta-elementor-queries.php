<?php
/**
 * Custom Queries for Elementor post widget
 *
 * @package Better Together
 */


/**
 * slug_tag query
 * Take the current page slug and query all posts with the same tag
 */
add_action( 'elementor/query/slug_tag', function( $query ) {
	global $post;
    $post_slug = $post->post_name;
	$query->set( 'tag', $post_slug );
} );

/**
 * child_post query
 * Showing children of current page in Posts Widget
 */
add_action( 'elementor_pro/posts/query/child_posts', function( $query ) {
	$current_page = get_queried_object_id();
	$query->set( 'post_parent', $current_page );
} );
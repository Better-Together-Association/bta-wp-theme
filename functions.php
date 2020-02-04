<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts' );

// Eventbrite embed

function bta_eventbrite_embed_register() {
	wp_register_script( 
		'bta-eventbrite-embed-vendor-script',
		'https://www.eventbrite.com/static/widgets/eb_widgets.js',
		'',
		false,
		true
	);
	wp_register_script( 
		'bta-eventbrite-embed-script',
		get_stylesheet_directory_uri() . '/js/eventbrite-script.js',
		[
			'bta-eventbrite-embed-vendor-script',
		],
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'bta_eventbrite_embed_register' );

// Add shortcode
function bta_eventbrite_embed_shortcode( $atts ) {

	$eventbrite_url_field_name = 'bta-program-eventbrite-url';

	// Attributes
	$atts = shortcode_atts(
		array(
			'eventId' => false,
			'iframeContainerHeight' => 425,
			'id' => 'eventbrite-widget-container',
			'callback' => 'defaultCallback'
		),
		$atts
	);

	if ( ! $atts['eventId'] ) {
		$re = '/\d+$/m';
		$url = get_field($eventbrite_url_field_name);
		if ( preg_match($re, $url, $matches) ) {
			$atts['eventId'] = $matches[0];
		}
	}
	
	if ( $atts['eventId'] ) {
		// Enqueue Scripts
		wp_enqueue_script( 'bta-eventbrite-embed-vendor-script' );
		wp_enqueue_script( 'bta-eventbrite-embed-script' );
		// Pass data to script
		wp_localize_script( 'bta-eventbrite-embed-script', 'btaEventbrite', $atts );
		
		return '<div id="' . $atts['id'] . '"></div>';
	} else {
		return '<!-- ' . __('No Eventbrite URL Found','bta') . '-->';
	}

}

add_shortcode( 'bta_eventbrite_embed', 'bta_eventbrite_embed_shortcode' );

// Custom Queries

// Show posts that match page slug name
add_action( 'elementor/query/programming_past', function( $query ) {
	global $post;
    $post_slug = $post->post_name;
	$query->set( 'tag', $post_slug );
} );

// Showing children of current page in Posts Widget
add_action( 'elementor_pro/posts/query/child_posts', function( $query ) {
	// Get current post tags
	$current_page = get_queried_object_id();
	// Modify the query
	$query->set( 'post_parent', $current_page );
} );


add_filter( 'login_url', 'bta_custom_login_url', 10, 3 );
/**
 * Filters the login URL.
 *
 * @since 2.8.0
 * @since 4.2.0 The `$force_reauth` parameter was added.
 *
 * @param string $login_url    The login URL. Not HTML-encoded.
 * @param string $redirect     The path to redirect to on login, if supplied.
 * @param bool   $force_reauth Whether to force reauthorization, even if a cookie is present.
 *
 * @return string
 */
function bta_custom_login_url( $login_url, $redirect, $force_reauth ){
    $login_url = site_url( '/login/', 'login' ); // @TODO make this dynamic...
    if ( ! empty( $redirect ) ) {
        $login_url = add_query_arg( 'redirect_to', urlencode( $redirect ), $login_url );
    }
    if ( $force_reauth ) {
        $login_url = add_query_arg( 'reauth', '1', $login_url );
    }
    return $login_url;
}

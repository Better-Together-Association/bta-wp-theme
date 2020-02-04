<?php
/**
 * Shortcodes set by the theme
 *
 * @package Better Together
 */


add_action( 'wp_enqueue_scripts', 'bta_shortcode_register' );
/**
 * Registers scripts and stylesheets for shortcodes
 *
 * @return  void
 */

function bta_shortcode_register() {
    // eventbrite embed vendor script from eventbrite
	wp_register_script( 
		'bta-eventbrite-embed-vendor-script',
		'https://www.eventbrite.com/static/widgets/eb_widgets.js',
		'',
		false,
		true
    );
    // eventbrite embed script
	wp_register_script( 
		'bta-eventbrite-embed-script',
		get_stylesheet_directory_uri() . '/js/eventbrite-script.js',
		[
			'bta-eventbrite-embed-vendor-script',
		],
		'1.0.0'
	);
}

add_shortcode( 'bta_eventbrite_embed', 'bta_eventbrite_embed_shortcode' );
/**
 * Adds shortcode for adding eventbrite widget to page
 * if eventId is not supplied then the shortcode looks
 * for the ACF field containing an eventbrite URL
 * set by $eventbrite_url_field_name
 * 
 * @TODO implement callback function
 * @TODO implement promocode attribute
 *
 * @param   array  $atts  array of attributes passed by shortcode
 *                        eventID - the eventbrite event ID
 *                        iframeContainerHeight - height of the widget
 *                        id - id of the html tag placed by shortcode
 *
 * @return  [type]         [return description]
 */
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

    // If no eventId grab
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
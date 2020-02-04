<?php
/**
 * Theme functions and definitions
 *
 * @package Better Together
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

// pull in shortcodes
require get_stylesheet_directory_uri() . '/includes/bta-shortcodes.php';

// pull in custom Elementor Queries
require get_stylesheet_directory_uri() . '/includes/bta-elementor-queries.php';

// pull in custom filters
require get_stylesheet_directory_uri() . '/includes/bta-filters.php';
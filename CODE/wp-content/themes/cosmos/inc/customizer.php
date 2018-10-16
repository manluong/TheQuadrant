<?php
/**
 * Theme Customizer
 *
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function cosmos_customize_preview_js() {
	wp_enqueue_script( 'cosmos_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20160508', true );
}
add_action( 'customize_preview_init', 'cosmos_customize_preview_js' );
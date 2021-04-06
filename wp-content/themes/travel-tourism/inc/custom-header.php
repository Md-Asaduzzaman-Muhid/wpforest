<?php
/**
 * @package Travel Tourism
 * Setup the WordPress core custom header feature.
 *
 * @uses travel_tourism_header_style()
*/
function travel_tourism_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'travel_tourism_custom_header_args', array(
		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1600,
		'height'                 => 400,
		'flex-width'             => true,
		'flex-height'            => true,
		'wp-head-callback'       => 'travel_tourism_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'travel_tourism_custom_header_setup' );

if ( ! function_exists( 'travel_tourism_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see travel_tourism_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'travel_tourism_header_style' );

function travel_tourism_header_style() {
	//Check if user has defined any header image.
	if ( get_header_image() ) :
	$custom_css = "
        #header{
			background-image:url('".esc_url(get_header_image())."');
			background-position: center top;
		}";
	   	wp_add_inline_style( 'travel-tourism-basic-style', $custom_css );
	endif;
}
endif;
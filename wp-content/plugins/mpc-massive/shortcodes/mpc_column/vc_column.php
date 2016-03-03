<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column
 */

/* MPC CUSTOM */
global $MPC_Column, $mpc_can_link;
$mpc_can_link_next = $mpc_can_link;

$mpc_atts = shortcode_atts( array(
    /* Link Block */
    'url'                     => '',
    'enable_sticky'           => '',
    'sticky_offset'           => '',
    'alignment'               => '',

    'animation_in_type'       => 'none',
    'animation_in_duration'   => '300',
    'animation_in_delay'      => '0',
    'animation_in_offset'     => '100',

    'animation_loop_type'     => 'none',
    'animation_loop_duration' => '1000',
    'animation_loop_delay'    => '1000',
    'animation_loop_hover'    => '',
), $atts );

$css_id  = $MPC_Column->shortcode_styles( $mpc_atts );
$data_id = ' data-column-id="' . $css_id . '"';

$animation = MPC_Snippets::parse_atts_animation( $atts );

$classes = ' '; // mpc-transition
$classes .= $animation != '' ? ' mpc-animation' : '';
$classes .= $mpc_atts[ 'enable_sticky' ] != '' ? ' mpc-column--sticky' : '';

$sticky_attr = $mpc_atts[ 'enable_sticky' ] != '' ? ' data-offset="' . esc_attr( $mpc_atts[ 'sticky_offset' ] ) . '"' : '';

/* Link Wrapper */
$url_settings = $mpc_can_link ? MPC_Snippets::parse_atts_url( $mpc_atts[ 'url' ] ) : '';
$wrapper = $url_settings != '' ? 'a' . $url_settings : 'div';

if( $url_settings != '' ) {
	$mpc_can_link = false;
}
/* MPC CUSTOM END */

/* VC */
$el_class = $width = $css = $offset = '';
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$width = wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );

$css_classes = array(
    $this->getExtraClass( $el_class ),
    'wpb_column',
    'vc_column_container',
    $width,
    $classes, // MPC CUSTOM
);

if ( MPC_MASSIVE_FALLBACK ) {
	$css_classes[] = vc_shortcode_custom_css_class( $css );
}

if ( function_exists( 'vc_shortcode_custom_css_has_property' ) && vc_shortcode_custom_css_has_property( $css, array('border', 'background') ) ) {
	$css_classes[] = 'vc_col-has-fill';
}

$wrapper_attributes = array();

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
$wrapper_attributes[] = $animation;
$wrapper_attributes[] = $sticky_attr;
$wrapper_attributes[] = $data_id;

$output .= '<' . $wrapper . ' ' . implode( ' ', $wrapper_attributes ) . '>';
if ( ! MPC_MASSIVE_FALLBACK ) {
	$output .= '<div class="vc_column-inner ' . esc_attr( trim( vc_shortcode_custom_css_class( $css ) ) ) . '">';
}
$output .= '<div class="wpb_wrapper">';
$output .= wpb_js_remove_wpautop( $content );
if ( ! MPC_MASSIVE_FALLBACK ) {
	$output .= '</div>';
}
$output .= '</div>';
$output .= '</' . $wrapper . '>';

echo $output;

$mpc_can_link = $mpc_can_link_next;
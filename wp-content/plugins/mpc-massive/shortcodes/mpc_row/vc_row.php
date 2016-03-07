<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $equal_height
 * @var $columns_placement
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row
 */

/* MPC CUSTOM */
global $MPC_Row, $mpc_can_link;
$mpc_can_link = $this->settings( 'base' ) === 'vc_row_inner' ? $mpc_can_link : true;

$mpc_atts = shortcode_atts( array(
	// Toggle
	'toggle_enable'                           => '',
	'toggle_state'                            => 'closed',
	'toggle_stretch'                          => '',
	'toggle_effect'                           => 'none',

	'toggle_font_preset'                      => '',
	'toggle_font_color'                       => '',
	'toggle_font_size'                        => '',
	'toggle_font_line_height'                 => '',
	'toggle_font_align'                       => '',
	'toggle_font_transform'                   => '',
	'toggle_title'                            => '',

	'toggle_background_type'                  => 'color',
	'toggle_background_color'                 => '',
	'toggle_background_image'                 => '',
	'toggle_background_image_size'            => 'large',
	'toggle_background_repeat'                => 'no-repeat',
	'toggle_background_size'                  => 'initial',
	'toggle_background_position'              => 'middle-center',
	'toggle_background_gradient'              => '#83bae3||#80e0d4||0;100||180||linear',

	'toggle_border_css'                       => '',
	'toggle_padding_css'                      => '',
	'toggle_margin_css'                       => '',

	'toggle_icon_position'                    => 'title-left',

	'toggle_icon_type'                        => 'icon',
	'toggle_icon'                             => '',
	'toggle_icon_character'                   => '',
	'toggle_icon_image'                       => '',
	'toggle_icon_image_size'                  => 'thumbnail',
	'toggle_icon_preset'                      => '',
	'toggle_icon_color'                       => '#333333',
	'toggle_icon_size'                        => '',

	'toggle_icon_background_type'             => 'color',
	'toggle_icon_background_color'            => '',
	'toggle_icon_background_image'            => '',
	'toggle_icon_background_image_size'       => 'large',
	'toggle_icon_background_repeat'           => 'no-repeat',
	'toggle_icon_background_size'             => 'initial',
	'toggle_icon_background_position'         => 'middle-center',
	'toggle_icon_background_gradient'         => '#83bae3||#80e0d4||0;100||180||linear',

	'toggle_icon_border_css'                  => '',
	'toggle_icon_padding_css'                 => '',
	'toggle_icon_margin_css'                  => '',

	// Toggle Hover
	'hover_toggle_font_preset'                => '',
	'hover_toggle_font_color'                 => '',
	'hover_toggle_font_size'                  => '',
	'hover_toggle_font_line_height'           => '',
	'hover_toggle_font_align'                 => '',
	'hover_toggle_font_transform'             => '',
	'hover_toggle_title'                      => '',

	'hover_toggle_background_type'            => 'color',
	'hover_toggle_background_color'           => '',
	'hover_toggle_background_image'           => '',
	'hover_toggle_background_image_size'      => 'large',
	'hover_toggle_background_repeat'          => 'no-repeat',
	'hover_toggle_background_size'            => 'initial',
	'hover_toggle_background_position'        => 'middle-center',
	'hover_toggle_background_gradient'        => '#83bae3||#80e0d4||0;100||180||linear',

	'hover_toggle_border_css'                 => '',

	'hover_toggle_icon_position'              => 'title-left',

	'hover_toggle_icon_type'                  => 'icon',
	'hover_toggle_icon'                       => '',
	'hover_toggle_icon_character'             => '',
	'hover_toggle_icon_image'                 => '',
	'hover_toggle_icon_image_size'            => 'thumbnail',
	'hover_toggle_icon_preset'                => '',
	'hover_toggle_icon_color'                 => '#333333',
	'hover_toggle_icon_size'                  => '',

	'hover_toggle_icon_background_type'       => 'color',
	'hover_toggle_icon_background_color'      => '',
	'hover_toggle_icon_background_image'      => '',
	'hover_toggle_icon_background_image_size' => 'large',
	'hover_toggle_icon_background_repeat'     => 'no-repeat',
	'hover_toggle_icon_background_size'       => 'initial',
	'hover_toggle_icon_background_position'   => 'middle-center',
	'hover_toggle_icon_background_gradient'   => '#83bae3||#80e0d4||0;100||180||linear',

	'hover_toggle_icon_border_css'            => '',

	// Separator
	'enable_top_separator'    => '',
	'top_separator_style'     => 'arrow-center',
	'top_separator_color'     => '',

	'enable_bottom_separator' => '',
	'bottom_separator_style'  => 'arrow-center',
	'bottom_separator_color'  => '',

	// Parallax
	'enable_parallax'         => '',
	'enable_parallax_pattern' => '',
	'parallax_style'          => 'classic',
	'parallax_background'     => '',

	// Overlay
	'enable_first_overlay'            => '',
	'first_overlay_opacity'           => '',

	'first_background_type'           => 'color',
	'first_background_color'          => '',
	'first_background_image'          => '',
	'first_background_image_size'     => 'large',
	'first_background_repeat'         => 'no-repeat',
	'first_background_size'           => 'initial',
	'first_background_position'       => 'middle-center',
	'first_background_gradient'       => '#83bae3||#80e0d4||0;100||180||linear',

	'enable_first_overlay_scrolling'  => '',
	'first_overlay_speed'             => '25',

	'enable_second_overlay'           => '',
	'second_overlay_opacity'          => '',

	'second_background_type'          => 'color',
	'second_background_color'         => '',
	'second_background_image'         => '',
	'second_background_image_size'    => 'large',
	'second_background_repeat'        => 'no-repeat',
	'second_background_size'          => 'initial',
	'second_background_position'      => 'middle-center',
	'second_background_gradient'      => '#83bae3||#80e0d4||0;100||180||linear',

	'enable_second_overlay_scrolling' => '',
	'second_overlay_speed'            => '25',

	// Date
	'enable_date'             => '',
	'from_date'               => '',
	'to_date'                 => '',

	// Animation
	'animation_in_type'       => 'none',
	'animation_in_duration'   => '300',
    'animation_in_delay'      => '0',
	'animation_in_offset'     => '100',

	'animation_loop_type'     => 'none',
	'animation_loop_duration' => '1000',
	'animation_loop_delay'    => '1000',
	'animation_loop_hover'    => '',

	// Link Block
	'url'                     => '',

	// VC Row
	'css'                     => '',
), $atts );

if ( $mpc_atts[ 'enable_date' ] == 'true' && ( $mpc_atts[ 'from_date' ] != '' || $mpc_atts[ 'to_date' ] != '' ) ) {
//	$pattern   = 'd/m/Y H:i';
	$current   = time();

	$from_date = $mpc_atts[ 'from_date' ] != '' ? strtotime( str_replace( '/', '-', $mpc_atts[ 'from_date' ] ) ) : $current - 1;
	$from_date = $from_date === false ? $current - 1 : $from_date;

	$to_date   = $mpc_atts[ 'to_date' ] != '' ? strtotime( str_replace( '/', '-', $mpc_atts[ 'to_date' ] ) ) : $current + 1;
	$to_date   = $to_date === false ? $current + 1 : $to_date;

	if ( $from_date >= $current || $to_date <= $current ) {
		return;
	}
}

$mpc_css_id = $MPC_Row->shortcode_styles( $mpc_atts );

$mpc_animation  = MPC_Snippets::parse_atts_animation( $mpc_atts );

$mpc_classes = '';
$mpc_classes .= $mpc_animation != '' ? ' mpc-animation' : '';

if ( $mpc_atts[ 'enable_bottom_separator' ] == 'true' || $mpc_atts[ 'enable_bottom_separator' ] == 'true' ) {
	$mpc_classes .= ' mpc-with-separator';
}

// MPC - TOGGLE ROW
if( $mpc_atts[ 'toggle_enable' ] ) {
	$mpc_icon       = MPC_Snippets::parse_atts_icon( $mpc_atts, 'toggle' );
	$mpc_hover_icon = MPC_Snippets::parse_atts_icon( $mpc_atts, 'hover_toggle' );

	$mpc_transition_classes = ' mpc-effect-' . $mpc_atts[ 'toggle_effect' ];
	$mpc_font_classes       = $mpc_atts[ 'toggle_font_preset' ] != '' ? ' mpc-typography--' . $mpc_atts[ 'toggle_font_preset' ] : '';
    $mpc_stretch_classes    = $mpc_atts[ 'toggle_stretch' ] != '' ? ' mpc-stretch' : '';
	$mpc_classes .= $mpc_atts[ 'toggle_state' ] == 'opened' ? ' mpc-toggled' : '';

	$mpc_atts[ 'toggle_title' ]       = $mpc_atts[ 'toggle_title' ] != '' ? '<span class="mpc-toggle-row__title">' . $mpc_atts[ 'toggle_title' ] . '</span>' : '';
	$mpc_atts[ 'hover_toggle_title' ] = $mpc_atts[ 'hover_toggle_title' ] != '' ? '<span class="mpc-toggle-row__title">' . $mpc_atts[ 'hover_toggle_title' ] . '</span>' : '';

	$mpc_force_position = '';
	if ( $mpc_atts[ 'toggle_icon_position' ] == 'button-left' ) {
		$mpc_force_position .= ' mpc-position--left';
	} elseif ( $mpc_atts[ 'toggle_icon_position' ] == 'button-right' ) {
		$mpc_force_position .= ' mpc-position--right';
	}

	$mpc_hover_force_position = '';
	if ( $mpc_atts[ 'hover_toggle_icon_position' ] == 'button-left' ) {
		$mpc_hover_force_position .= ' mpc-position--left';
	} elseif ( $mpc_atts[ 'hover_toggle_icon_position' ] == 'button-right' ) {
		$mpc_hover_force_position .= ' mpc-position--right';
	}

	$mpc_icon       = '<span class="mpc-toggle-row__icon-wrap"><i class="mpc-toggle-row__icon mpc-transition' . $mpc_icon[ 'class' ] . '">' . $mpc_icon[ 'content' ] . '</i></span>';
	$mpc_hover_icon = '<span class="mpc-toggle-row__icon-wrap"><i class="mpc-toggle-row__icon mpc-transition' . $mpc_hover_icon[ 'class' ] . '">' . $mpc_hover_icon[ 'content' ] . '</i></span>';

	$mpc_regular = '';
	if ( $mpc_atts[ 'toggle_icon_position' ] == 'title-left' || $mpc_atts[ 'toggle_icon_position' ] == 'button-left' ) {
		$mpc_regular .= $mpc_icon . $mpc_atts[ 'toggle_title' ];
	} else {
		$mpc_regular .= $mpc_atts[ 'toggle_title' ] . $mpc_icon;
	}

	$mpc_hover = '';
	if ( $mpc_atts[ 'hover_toggle_icon_position' ] == 'title-left' || $mpc_atts[ 'hover_toggle_icon_position' ] == 'button-left' ) {
		$mpc_hover .= $mpc_hover_icon . $mpc_atts[ 'hover_toggle_title' ];
	} else {
		$mpc_hover .= $mpc_atts[ 'hover_toggle_title' ] . $mpc_hover_icon;
	}

	$mpc_toggle_row = '<div id="' . $mpc_css_id . '" class="mpc-toggle-row' . $mpc_classes . $mpc_stretch_classes . $mpc_font_classes . $mpc_transition_classes . '" ' . $mpc_animation . '>';
		$mpc_toggle_row .= '<div class="mpc-toggle-row__content">';
			$mpc_toggle_row .= '<div class="mpc-toggle-row__heading mpc-regular' . $mpc_force_position . '">' . $mpc_regular . '</div>';
			$mpc_toggle_row .= '<div class="mpc-toggle-row__heading mpc-hover' . $mpc_hover_force_position . '">' . $mpc_hover . '</div>';
		$mpc_toggle_row .= '</div>';
	$mpc_toggle_row .= '</div>';
}

// MPC - LINK WRAPPER
$mpc_url_settings = $mpc_can_link ? MPC_Snippets::parse_atts_url( $mpc_atts[ 'url' ] ) : '';
$mpc_wrapper  = $mpc_url_settings != '' ? 'a' . $mpc_url_settings : 'div';

if( $mpc_url_settings != '' ) {
	$mpc_can_link = false;
}
/* MPC CUSTOM END */

/* VC */
$el_class = $full_height = $full_width = $equal_height = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = '';
$output = $after_output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

// MPC - filter the $atts array to VC params before extraction
$vc_atts = array(
	'el_class'          => isset( $atts[ 'el_class' ] ) ? $atts[ 'el_class' ] : '',
	'full_width'        => isset( $atts[ 'full_width' ] ) ? $atts[ 'full_width' ] : '',
	'full_height'       => isset( $atts[ 'full_height' ] ) ? $atts[ 'full_height' ] : '',
	'equal_height'      => isset( $atts[ 'equal_height' ] ) ? $atts[ 'equal_height' ] : '',
	'columns_placement' => isset( $atts[ 'columns_placement' ] ) ? $atts[ 'columns_placement' ] : '',
	'content_placement' => isset( $atts[ 'content_placement' ] ) ? $atts[ 'content_placement' ] : '',
	'gap'               => isset( $atts[ 'gap' ] ) ? $atts[ 'gap' ] : '',
	'css'               => isset( $atts[ 'css' ] ) ? $atts[ 'css' ] : '',
	'el_id'             => isset( $atts[ 'el_id' ] ) ? $atts[ 'el_id' ] : '',
	'video_bg'          => isset( $atts[ 'video_bg' ] ) ? $atts[ 'video_bg' ] : '',
	'video_bg_url'      => isset( $atts[ 'video_bg_url' ] ) ? $atts[ 'video_bg_url' ] : '',
	'video_bg_parallax' => isset( $atts[ 'video_bg_parallax' ] ) ? $atts[ 'video_bg_parallax' ] : '',
);

extract( $vc_atts );

wp_enqueue_script( 'wpb_composer_front_js' );

$el_class = $this->getExtraClass( $el_class );

// MPC - MERGE CLASSES
$el_class = $el_class . $mpc_classes;

$css_classes = array(
	'vc_row',
	'wpb_row', //deprecated
	'vc_row-fluid',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

if ( ( function_exists( 'vc_shortcode_custom_css_has_property' ) && vc_shortcode_custom_css_has_property( $css, array( 'border', 'background' ) ) ) || $video_bg || $parallax ) {
	$css_classes[] = 'vc_row-has-fill';
}

if ( ! empty( $vc_atts['gap'] ) ) {
	$css_classes[] = 'vc_column-gap-'.$vc_atts['gap'];
}

$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
if ( ! empty( $full_width ) ) {
	$wrapper_attributes[] = 'data-vc-full-width="true"';
	$wrapper_attributes[] = 'data-vc-full-width-init="false"';
	if ( 'stretch_row_content' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
	} elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
		$css_classes[] = 'vc_row-no-padding';
	}
	$after_output .= '<div class="vc_row-full-width"></div>';
}

if ( ! empty( $full_height ) ) {
	$css_classes[] = ' vc_row-o-full-height';
	if ( ! MPC_MASSIVE_FALLBACK && ! empty( $columns_placement ) ) {
		$flex_row = true;
		$css_classes[] = ' vc_row-o-columns-' . $columns_placement;
	}

	if ( MPC_MASSIVE_FALLBACK && ! empty( $content_placement ) ) {
		$css_classes[] = ' vc_row-o-content-' . $content_placement;
	}
}

if ( ! empty( $equal_height ) ) {
	$flex_row = true;
	$css_classes[] = ' vc_row-o-equal-height';
}

if ( ! MPC_MASSIVE_FALLBACK && ! empty( $content_placement ) ) {
	$flex_row = true;
	$css_classes[] = ' vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$css_classes[] = ' vc_row-flex';
}

$has_video_bg = ( ! empty( $video_bg ) && ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

$parallax = '';
$parallax_image = '';

if ( $has_video_bg ) {
	$parallax = $video_bg_parallax;
	$parallax_image = $video_bg_url;
	$css_classes[] = ' vc_video-bg-container';
	wp_enqueue_script( 'vc_youtube_iframe_api_js' );
}

if ( ! empty( $parallax ) ) {
	wp_enqueue_script( 'vc_jquery_skrollr_js' );
	$wrapper_attributes[] = 'data-vc-parallax="1.5"'; // parallax speed
	$css_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
	if ( false !== strpos( $parallax, 'fade' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fade';
		$wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
	} elseif ( false !== strpos( $parallax, 'fixed' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fixed';
	}
}

if ( ! empty( $parallax_image ) ) {
	if ( $has_video_bg ) {
		$parallax_image_src = $parallax_image;

		$wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image_src ) . '"';
    }
}
if ( ! $parallax && $has_video_bg ) {
	$wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
}
$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

// MPC - SEPARATOR
$mpc_css_types = array(
	'tip-center',
	'tip-left',
	'tip-right',
	'split-inner',
	'split-outer',
	'teeth-left',
	'teeth-center',
	'teeth-right',
);

$mpc_top_separator    = '';
$mpc_bottom_separator = '';

if ( $mpc_atts[ 'enable_top_separator' ] == 'true' ) {
	$mpc_top_separator .= '<div class="mpc-separator-spacer mpc-separator--top"></div>';
	$mpc_top_separator_color = $mpc_atts[ 'top_separator_color' ] != '' ? 'data-color="' . $mpc_atts[ 'top_separator_color' ] . '"' : '';

	if ( array_search( $mpc_atts[ 'top_separator_style' ], $mpc_css_types ) !== false ) {
		$mpc_top_separator .= '<div class="mpc-separator mpc-separator--css mpc-separator--top mpc-separator-style--' . $mpc_atts[ 'top_separator_style' ] . '" ' . $mpc_top_separator_color . '><div class="mpc-separator-content"></div></div>';
	} else {
		if ( strpos( $mpc_atts[ 'top_separator_style' ], 'circle' ) === 0 ) {
			$aspect_ratio = '';
			$viewbox = '0 0 200 100';
		} else {
			$aspect_ratio = 'preserveAspectRatio="none"';
			$viewbox = '0 0 100 100';
		}

		$mpc_top_separator .= '<svg class="mpc-separator mpc-separator--top mpc-separator-style--' . $mpc_atts[ 'top_separator_style' ] . '" ' . $mpc_top_separator_color . ' width="100%" height="100" viewBox="' . $viewbox . '" ' . $aspect_ratio . ' version="1.1" xmlns="http://www.w3.org/2000/svg">';
		$mpc_top_separator .= MPC_Row::get_shape_top( $mpc_atts[ 'top_separator_style' ] );
		$mpc_top_separator .= '</svg>';
	}
}

if ( $mpc_atts[ 'enable_bottom_separator' ] == 'true' ) {
	$mpc_bottom_separator .= '<div class="mpc-separator-spacer mpc-separator--bottom"></div>';
	$mpc_bottom_separator_color = $mpc_atts[ 'bottom_separator_color' ] != '' ? 'data-color="' . $mpc_atts[ 'bottom_separator_color' ] . '"' : '';

	if ( array_search( $mpc_atts[ 'bottom_separator_style' ], $mpc_css_types ) !== false ) {
		$mpc_bottom_separator .= '<div class="mpc-separator mpc-separator--css mpc-separator--bottom mpc-separator-style--' . $mpc_atts[ 'bottom_separator_style' ] . '" ' . $mpc_bottom_separator_color . '><div class="mpc-separator-content"></div></div>';
	} else {
		if ( strpos( $mpc_atts[ 'bottom_separator_style' ], 'circle' ) === 0 ) {
			$aspect_ratio = '';
			$viewbox = '0 0 200 100';
		} else {
			$aspect_ratio = 'preserveAspectRatio="none"';
			$viewbox = '0 0 100 100';
		}

		$mpc_bottom_separator .= '<svg class="mpc-separator mpc-separator--bottom mpc-separator-style--' . $mpc_atts[ 'bottom_separator_style' ] . '" ' . $mpc_bottom_separator_color . ' width="100%" height="100" viewBox="' . $viewbox . '" ' . $aspect_ratio . ' version="1.1" xmlns="http://www.w3.org/2000/svg">';
		$mpc_bottom_separator .= MPC_Row::get_shape_bottom( $mpc_atts[ 'bottom_separator_style' ] );
		$mpc_bottom_separator .= '</svg>';
	}
}

// MPC - PARALLAX
$mpc_parallax = '';
if ( $mpc_atts[ 'enable_parallax' ] == 'true' && $mpc_atts[ 'parallax_background' ] != '' ) {
	$mpc_parallax_image = wp_get_attachment_url( $mpc_atts[ 'parallax_background' ] );

	if ( $mpc_parallax_image != false ) {
		$mpc_parallax_options = '';

		if ( $mpc_atts[ 'parallax_style' ] == 'classic' ) {
//			$mpc_parallax_options = 'data-bottom-top="top: -25%" data-top-bottom="top: 0%"';
			$mpc_parallax_options = 'data-bottom-top="transform: translateY(-25%)" data-top-bottom="transform: translateY(0%)"';
		} elseif ( $mpc_atts[ 'parallax_style' ] == 'classic-fast' ) {
//			$mpc_parallax_options = 'data-bottom-top="top: -50%" data-top-bottom="top: 0%"';
			$mpc_parallax_options = 'data-bottom-top="transform: translateY(-50%)" data-top-bottom="transform: translateY(0%)"';
		} elseif ( $mpc_atts[ 'parallax_style' ] == 'horizontal-left' ) {
//			$mpc_parallax_options = 'data-bottom-top="left: 0%" data-top-bottom="left: -25%"';
			$mpc_parallax_options = 'data-bottom-top="transform: translateX(0%)" data-top-bottom="transform: translateX(-25%)"';
		} elseif ( $mpc_atts[ 'parallax_style' ] == 'horizontal-right' ) {
//			$mpc_parallax_options = 'data-bottom-top="right: 0%" data-top-bottom="right: -25%"';
			$mpc_parallax_options = 'data-bottom-top="transform: translateX(-25%)" data-top-bottom="transform: translateX(0%)"';
		} elseif ( $mpc_atts[ 'parallax_style' ] == 'fade' ) {
			$wrapper_attributes[] = 'data-15p-center-bottom="opacity: 1"';
			$wrapper_attributes[] = 'data-top-bottom="opacity: 0"';
		}

		$mpc_parallax = '<div class="mpc-parallax-wrap"><div class="mpc-parallax mpc-parallax-style--' . $mpc_atts[ 'parallax_style' ] . '" ' . $mpc_parallax_options . '></div></div>';
	}
}

// MPC - OVERLAY
$wrapper_attributes[] = 'data-row-id="' . $mpc_css_id . '"';

$mpc_first_overlay = '';
if ( $mpc_atts[ 'enable_first_overlay' ] == 'true' ) {
	$mpc_first_overlay = '<div class="mpc-overlay mpc-overlay--first' . ( $mpc_atts[ 'first_background_type' ] == 'image' && $mpc_atts[ 'enable_first_overlay_scrolling' ] ? ' mpc-overlay--scrolling' : '' ) . '" data-speed="' . $mpc_atts[ 'first_overlay_speed' ] . '"></div>';
}

$mpc_second_overlay = '';
if ( $mpc_atts[ 'enable_second_overlay' ] == 'true' ) {
	$mpc_second_overlay = '<div class="mpc-overlay mpc-overlay--second' . ( $mpc_atts[ 'second_background_type' ] == 'image' && $mpc_atts[ 'enable_second_overlay_scrolling' ] ? ' mpc-overlay--scrolling' : '' ) . '" data-speed="' . $mpc_atts[ 'second_overlay_speed' ] . '"></div>';
}

// MPC - TOGGLE WRAP
if( $mpc_atts[ 'toggle_enable' ] ) {
	echo $mpc_toggle_row;
}

// MPC - ANIMATION
$wrapper_attributes[] = $mpc_animation;

$output .= '<' . $mpc_wrapper . ' ' . implode( ' ', $wrapper_attributes ) . '>';

$output .= $mpc_parallax;

$output .= $mpc_first_overlay;
$output .= $mpc_second_overlay;

$output .= $mpc_top_separator;

$output .= wpb_js_remove_wpautop( $content );

$output .= $mpc_bottom_separator;

$output .= '</' . $mpc_wrapper . '>';
$output .= $after_output;

echo $output;

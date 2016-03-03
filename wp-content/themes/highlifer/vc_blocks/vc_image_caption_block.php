<?php 

/**
 * The Shortcode
 */
function ebor_image_caption_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'image' => '',
				'type' => 'hover-caption'
			), $atts 
		) 
	);
	
	$output = '
	    <div class="image-caption cast-shadow '. $type .'">
	        '. wp_get_attachment_image( $image, 'full' ) .'
	        <div class="caption">
	            '. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
	        </div>
	    </div>
    ';
	
	return $output;
}
add_shortcode( 'foundry_image_caption', 'ebor_image_caption_shortcode' );

/**
 * The VC Functions
 */
function ebor_image_caption_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'foundry-vc-block',
			"name" => __("Image Caption", 'foundry'),
			"base" => "foundry_image_caption",
			"category" => __('Foundry WP Theme', 'foundry'),
			"params" => array(
				array(
					"type" => "attach_image",
					"heading" => __("Block Image", 'foundry'),
					"param_name" => "image"
				),
				array(
					"type" => "dropdown",
					"heading" => __("Display Type", 'foundry'),
					"param_name" => "type",
					"value" => array(
						'Caption on Hover' => 'hover-caption',
						'Static Caption' => 'mb-xs-32'
					)
				),
				array(
					"type" => "textarea_html",
					"heading" => __("Caption Content", 'foundry'),
					"param_name" => "content",
					'holder' => 'div'
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'ebor_image_caption_shortcode_vc' );
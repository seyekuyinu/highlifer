<?php 

/**
 * The Shortcode
 */
function ebor_twitter_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'layout' => 'carousel',
				'amount' => '5'
			), $atts 
		) 
	);
	
	if( 'carousel' == $layout ){
		$output = '
			<div class="text-center">
			    <i class="ti-twitter-alt icon icon-lg color-primary mb40 mb-xs-24"></i>
			    <div class="twitter-feed tweets-slider large">
			        <div class="tweets-feed" data-widget-id="'. esc_attr($title) .'" data-amount="'. esc_attr($amount) .'">
			        </div>
			    </div>
			</div>
		';
	} else {
		$output = '
			<div class="row">
				<div class="twitter-feed thirds">
				    <div class="tweets-feed" data-widget-id="'. esc_attr($title) .'" data-amount="'. esc_attr($amount) .'">
				    </div>
				</div>
			</div>
		';
	}
	
	return $output;
}
add_shortcode( 'foundry_twitter', 'ebor_twitter_shortcode' );

/**
 * The VC Functions
 */
function ebor_twitter_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'foundry-vc-block',
			"name" => __("Twitter Feed", 'foundry'),
			"base" => "foundry_twitter",
			"category" => __('Foundry WP Theme', 'foundry'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => __("Twitter User ID", 'foundry'),
					"param_name" => "title",
					"description" => "Twitter Widget ID <code>e.g: 492085717044981760</code><br /><br />
					<strong>Note!</strong> You need to generate this ID from your account, do this by going to the 'Settings' page of your Twitter account and clicking 'Widgets'. Click 'Create New' and then 'Create Widget'. One done, go back to the 'Widgets' page and click 'Edit' on your newly created widget. From here you need to copy the widget id out of the url bar. The widget id is the long numerical string after /widgets/ and before /edit.",
				),
				array(
					"type" => "dropdown",
					"heading" => __("Display Type", 'foundry'),
					"param_name" => "layout",
					"value" => array(
						'Twitter Carousel' => 'carousel',
						'Tweets Grid' => 'grid'
					)
				),
				array(
					"type" => "textfield",
					"heading" => __("Load how many tweets? Numeric Only.", 'foundry'),
					"param_name" => "amount",
					'value' => '5',
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'ebor_twitter_shortcode_vc' );
<?php 

/**
 * The Shortcode
 */
function ebor_instagram_block_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'id' => '',
				'token' => '',
				'button_text' => 'Follow me @ Instagram',
				'button_url' => ''
			), $atts 
		) 
	);
	
	ob_start();
?>
	
	<div class="instagram-wrapper">
		<div id="instafeed"></div>
		<a href="<?php echo esc_url($button_url); ?>" target="_blank" class="btn btn-full"><?php echo esc_html($button_text); ?></a>
	</div>
	
	<script type="text/javascript">
		jQuery(document).ready(function(){
			
			/*-----------------------------------------------------------------------------------*/
			/*	INSTAGRAM
			/*-----------------------------------------------------------------------------------*/
			var instagramFeed = new Instafeed({
			    get: 'user',
			    userId: <?php echo esc_js($id); ?>,
			    accessToken: '<?php echo esc_js($token); ?>',
			    resolution: 'standard_resolution',
			    template: '<div class="item"><figure class="overlay"><a href="{{link}}" target="_blank"><img src="{{image}}" /></a></figure></div>',
			    after: function() {
			        jQuery('#instafeed figure.overlay a').prepend('<span class="over"></span>');
			        jQuery('#instafeed').owlCarousel({
			            loop: false,
			            margin: 0,
			            nav: true,
			            navText: ['', ''],
			            dots: false,
			            responsive: {
			                0: {
			                    items: 3
			                },
			                768: {
			                    items: 4
			                },
			                1000: {
			                    items: 5
			                },
			                1680: {
			                    items: 6
			                },
			                1920: {
			                    items: 7
			                }
			            }
			        })
			    }
			});
			jQuery('#instafeed').each(function() {
			    instagramFeed.run();
			});

		});
	</script>
	
<?php
	$output = ob_get_contents();
	ob_end_clean();
	
	return $output;
}
add_shortcode( 'malory_instagram_block', 'ebor_instagram_block_shortcode' );

/**
 * The VC Functions
 */
function ebor_instagram_block_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'malory-vc-block',
			"name" => esc_html__("Instagram Feed", 'malory'),
			"base" => "malory_instagram_block",
			"category" => esc_html__('malory WP Theme', 'malory'),
			'description' => 'A swiper of Instagram images.',
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Numeric User ID", 'malory'),
					"param_name" => "id"
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Access Token", 'malory'),
					"param_name" => "token",
					'description' => 'This is the Instagram block, it will grab your latest Instagram images. For this to work, the block requires you enter a numeric ID in the correct field, and also an access token in the correct field. Please grab your numeric Instagram ID & Access Token from here: <a href="https://instagram.com/oauth/authorize/?client_id=467ede5a6b9b48ae8e03f4e2582aeeb3&redirect_uri=http://instafeedjs.com&response_type=token" target="_blank">Get User ID & Token</a>'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Button Text", 'malory'),
					"param_name" => "button_text",
					"value" => 'Follow me @ Instagram',
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Button URL", 'malory'),
					"param_name" => "button_url"
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'ebor_instagram_block_shortcode_vc' );
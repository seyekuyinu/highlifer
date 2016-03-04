<?php 	
	get_header();
	
	$term = get_queried_object();
	
	echo ebor_get_page_title( 
		esc_html__('In: ','foundry') . $term->name, 
		$subtitle = $term->description, 
		$icon = false, 
		$thumbnail = ( get_option('foundry_blog_header_image') ) ? '<img src="'. get_option('foundry_blog_header_image') .'" alt="Blog Header" class="background-image" />' : false, 
		$layout = get_option('foundry_blog_header_layout', 'left-short-grey')
	);
	
	get_template_part('loop/loop-post', get_option('blog_layout','masonry-sidebar-right'));
	
	get_footer();
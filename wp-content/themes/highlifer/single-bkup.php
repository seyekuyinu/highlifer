<?php
	get_header();
	the_post();
	
	//Calculate required sidebar layout
	$active = is_active_sidebar('primary');
	$sidebar = ( isset($_GET['layout']) ) ? $_GET['layout'] : false;
	$layout = ( $sidebar ) ? $sidebar : get_option('foundry_post_layout','sidebar-right');
	$layout = ( $active ) ? $layout : 'sidebar-none';
	
	$thumbnail = false;
	if( has_post_thumbnail( $post->ID ) ){
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
	}

	

	
?>



<section class="page-title page-title-1 image-bg overlay parallax">
	
	 
	
	<div class="background-image-holder fadeIn" style="transform: translate3d(0px, 47.5px, 0px); top: -100px; background: url(<?php  $image[0]; ?>);"></div>
	
	
				
			</section>
<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="container">
        <div class="row">
        	<?php get_template_part('inc/content-post', $layout); ?>
        </div>
    </div>
</section>

<?php get_footer();
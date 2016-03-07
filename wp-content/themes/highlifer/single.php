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




<section class="page-title page-title-2 image-bg overlay parallax"><div class="background-image-holder fadeIn" style="transform: translate3d(0px, 155.5px, 0px); top: -100px; background: url();"><img width="1440" height="960" src="<?php echo $image[0]; ?>" class="background-image" alt="cover14" sizes="(max-width: 1440px) 100vw, 1440px" scale="0" style="display: none;"></div>
				<div class="container">
				    <div class="row">
				    
				        <div class="col-md-6">
				        	<h2 class="uppercase mb8"> <?php the_title(); ?></h2>
				        	<p class="lead mb0 d0"><?php the_date(); ?>.</p>
				        </div>
				        
				        <div class="col-md-6 text-right">
				        	<ol class="breadcrumb breadcrumb-2"><li><?php the_category(); ?></li><li class="active">***</li></ol>
				        </div>
				        
				    </div>
				</div>
</section>


<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <div class="container">
    <div class="row">
      <?php get_template_part('inc/content-post', $layout); ?>
    </div>
  </div>
</section>
<?php get_footer();

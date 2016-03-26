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

<section class="page-title page-title-2 image-bg overlay parallax">
  <div class="background-image-holder fadeIn" style="transform: translate3d(0px, 155.5px, 0px); top: -100px; background: url();"><img width="1440" height="960" src="<?php echo $image[0]; ?>" class="background-image" alt="cover14" sizes="(max-width: 1440px) 100vw, 1440px" scale="0" style="display: none;"></div>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="uppercase mb8">
          <?php the_title(); ?>
        </h2>
        <p class="lead mb0 d0 datefader">
          <?php the_date(); ?>
          .</p>
      </div>
      <div class="col-md-6 text-right">
               <img src="<?php bloginfo('siteurl');?>/wp-content/uploads/2016/02/thumb-1.png "/>
               <ol class="breadcrumb breadcrumb-2">
          <li>
            <?php the_category(); ?>
          </li>
          <li class="active">***</li>
        </ol>

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

<!-- <a class="btn btn-lg btn-modal" href="#" modal-link="621"><i class="ti-id-badge"></i> Image Background</a> -->

<div class="foundry_modal text-center image-bg overlay"   modal-link="621"><i class="ti-close close-modal"></i>
  <div class="background-image-holder"> <img width="800" height="534" src="//localhost/highlifer/wp-content/uploads/2015/07/Unknown-12.jpeg" class="background-image" alt="Unknown-1" srcset="//localhost/highlifer/wp-content/uploads/2015/07/Unknown-12-300x200.jpeg 300w, //localhost/highlifer/wp-content/uploads/2015/07/Unknown-12-768x513.jpeg 768w, //localhost/highlifer/wp-content/uploads/2015/07/Unknown-12-600x400.jpeg 600w, //localhost/highlifer/wp-content/uploads/2015/07/Unknown-12.jpeg 800w" sizes="(max-width: 800px) 100vw, 800px" /> </div>
  <div class="wpb_text_column wpb_content_element ">
    <div class="wpb_wrapper">
      <h3 class="uppercase" style="text-align: center;">SIGN UP &amp; BE COOL.</h3>
      <p class="lead mb48" style="text-align: center;">Stay in the loop with our awesome newsletter. We&#8217;ll send you monthly<br />
        updates of our latest and greatest tools and resources.</p>
    </div>
  </div>
  <div role="form" class="wpcf7" id="wpcf7-f274-p932-o2" lang="en-US" dir="ltr">
    <div class="screen-reader-response"></div>
    <form action="/highlifer/elements/modals/#wpcf7-f274-p932-o2" method="post" class="wpcf7-form" novalidate>
      <div style="display: none;">
        <input type="hidden" name="_wpcf7" value="274" />
        <input type="hidden" name="_wpcf7_version" value="4.3.1" />
        <input type="hidden" name="_wpcf7_locale" value="en_US" />
        <input type="hidden" name="_wpcf7_unit_tag" value="wpcf7-f274-p932-o2" />
        <input type="hidden" name="_wpnonce" value="5936df243d" />
      </div>
      <div class="halves"><span class="wpcf7-form-control-wrap your-email">
        <input type="email" name="your-email" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" aria-required="true" aria-invalid="false" placeholder="Your email" />
        </span>
        <input type="submit" value="Notify Me" class="wpcf7-form-control wpcf7-submit" />
      </div>
      <div class="wpcf7-response-output wpcf7-display-none"></div>
    </form>
  </div>
</div>
<?php get_footer();


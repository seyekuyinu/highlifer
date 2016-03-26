				
<?php 
	/**
	 * First, we need to check if we're going to override the header layout (with post meta)
	 * Or if we're going to display the global choice from the theme options.
	 * This is what ebor_get_header_layout is in charge of.
	 * 
	 * Oh yeah, exactly the same for the footer as well.
	 */
	get_template_part('inc/content-footer', ebor_get_footer_layout()); 
?>	

</div><!--/body-wrapper-->

<?php 
	get_template_part('inc/content-footer','modal');
	
	global $foundry_modal_content;
	echo do_shortcode($foundry_modal_content);
	
	wp_footer(); 
?>


	<script type="text/javascript">
		jQuery(function(){ // document ready

		  if (!!jQuery('.scrollless').offset()) { // make sure ".sticky" element exists
			
			var windowWhatSize = jQuery(window).width();  
			var approvedSize = 600;

		    var stickyTop = jQuery('.scrollless').offset().top; // returns number 

		    jQuery(window).scroll(function(){ // scroll event

		      var windowTop = jQuery(window).scrollTop(); // returns number 

		      if ((stickyTop < windowTop) && (windowWhatSize > approvedSize) ) {
		        jQuery('.scrollless').css({ position: 'fixed', top: '80px', right: '60px' });

		      }
		      else {
		        jQuery('.scrollless').css('position','static');
		      }

		    });

		  }

		});
		
		
		/** teacher, who knows how to fade elements when they scroll? **/
		jQuery(window).scroll(function(){
    jQuery(".mb8").css("opacity", 1 - jQuery(window).scrollTop() / 250);
    jQuery(".datefader").css("opacity", 1 - jQuery(window).scrollTop() / 250);

  });
	</script>

</body>
</html>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            
                <?php
                	/**
                	 * woocommerce_before_shop_loop hook
                	 *
                	 * @hooked woocommerce_result_count - 20
                	 * @hooked woocommerce_catalog_ordering - 30
                	 */
                	do_action( 'woocommerce_before_shop_loop' );
                ?>
                
                <div class="row">
                    <div class="col-sm-12">
                        <hr>
                    </div>
                </div>
                
                <?php if ( have_posts() ) : ?>
                			
	                <?php woocommerce_product_loop_start(); ?>
	                
	    				<?php woocommerce_product_subcategories(); ?>
	    
	    				<?php while ( have_posts() ) : the_post(); ?>
	    
	    					<?php wc_get_template_part( 'content', 'product-2col' ); ?>
	    
	    				<?php endwhile; // end of the loop. ?>
	    
	    			<?php woocommerce_product_loop_end(); ?>
	    			
	    		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
	    		
					<?php wc_get_template( 'loop/no-products-found.php' ); ?>
		
				<?php endif; ?>
                			
                <div class="text-center mt40">
                    <?php
                    	/**
                    	 * woocommerce_after_shop_loop hook
                    	 *
                    	 * @hooked woocommerce_pagination - 10
                    	 */
                    	do_action( 'woocommerce_after_shop_loop' );
                    ?>
                </div>
                
            </div>
        </div>
    </div>
</section>
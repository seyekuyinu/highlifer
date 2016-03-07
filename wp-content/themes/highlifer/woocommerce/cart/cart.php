<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<div class="row">
<div class="col-md-8">

<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="table cart mb48">
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th><?php _e( 'Product', 'foundry' ); ?></th>
			<th><?php _e( 'Description', 'foundry' ); ?></th>
			<th><?php _e( 'Quantity', 'foundry' ); ?></th>
			<th><?php _e( 'Subtotal', 'foundry' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
				
					<th scope="row">
					    <?php
					    	echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( 
					    		'<a href="%s" class="remove-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="%s"><i class="ti-close"></i></a>', 
					    		esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
					    		__( 'Remove this item', 'foundry' ) ), 
					    		$cart_item_key );
					    ?>
					</th>
					<td>
					    <?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $_product->is_visible() ) {
								echo htmlspecialchars_decode($thumbnail);
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $thumbnail );
							}
						?>
					</td>
					<td>
					    <span>
					    	<?php
								if ( ! $_product->is_visible() ) {
									echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
								} else {
									echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key );
								}
	
								// Meta data
								echo WC()->cart->get_item_data( $cart_item );
	
								// Backorder notification
								if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
									echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'foundry' ) . '</p>';
								}
							?>
					    </span>
					</td>
					<td>
					    <span>
					    	<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input( array(
										'input_name'  => "cart[{$cart_item_key}][qty]",
										'input_value' => $cart_item['quantity'],
										'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
										'min_value'   => '0'
									), $_product, false );
								}
	
								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
							?>
					    </span>
					</td>
					<td>
					    <span>
					    	<?php
					    		echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
					    	?>
					    </span>
					</td>
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="6" class="actions">
			
				<input type="submit" class="button" name="update_cart" value="<?php _e( 'Update Cart', 'foundry' ); ?>" />

				<?php if ( WC()->cart->coupons_enabled() ) { ?>
					<div class="thirds text-center mb-xs-24">

						<h5 class="uppercase">Add a coupon code</h5>
						<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php _e( 'Coupon code', 'foundry' ); ?>" /> 
						<input type="submit" class="hollow" name="apply_coupon" value="<?php _e( 'Apply', 'foundry' ); ?>" />

						<?php do_action( 'woocommerce_cart_coupon' ); ?>
					</div>
				<?php } ?>

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

</div>

<div class="col-md-4">
<div class="mb24">
    <h5 class="uppercase">Your Order Total</h5>
    <?php do_action( 'woocommerce_cart_collaterals' ); ?>
</div>
</div>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>

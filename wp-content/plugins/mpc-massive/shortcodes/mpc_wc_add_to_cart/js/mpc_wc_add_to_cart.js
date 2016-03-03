/*----------------------------------------------------------------------------*\
	ADD TO CART SHORTCODE
\*----------------------------------------------------------------------------*/
( function( $ ) {
	"use strict";

	function add_to_cart_call( _ev, $button ) {
		var cart_data = $button.data( 'cart' ),
		    $notices = $button.find( '.mpc-atc__notices' );

		if( cart_data && !$button.is( '.mpc-disabled' ) ) {
			_ev.preventDefault();

			$button.addClass( 'mpc-disabled' );
			//$notices.attr( 'data-notice', 'show:loader' );
			$button.attr( 'data-notice', 'show:loader' );

			$.post(
				_mpc_vars.ajax_url,
				{
					action: 'mpc_wc_add_to_cart',
					product_id: cart_data.product_id,
					variation_id: cart_data.variation_id,
					dataType: 'json'
				},
				function( _response ) {
					if( _response ) {
						//$notices.attr( 'data-notice', 'show:success' );
						$button.attr( 'data-notice', 'show:success' );
					} else {
						//$notices.attr( 'data-notice', 'show:error' );
						$button.attr( 'data-notice', 'show:error' );

						setTimeout( function() {
							//$notices.removeAttr( 'data-notice' );
							$button.removeClass( 'mpc-disabled' )
									.removeAttr( 'data-notice' );
						}, 2000 );
					}
				}
			);
		} else if( $button.is( '.mpc-disabled' ) && $notices.attr( 'data-notice' ) != '' ) {
			$button.removeClass( 'mpc-disabled' )
					.removeAttr( 'data-notice' );
			//$notices.removeAttr( 'data-notice' );
		}
	}

	function init_shortcode( $button ) {
		//setTimeout( function() {
			var $title = $button.find( '.mpc-atc__title' ),
				$title_hover = $button.find( '.mpc-atc__title-hover' );

			//$title.css( {
			//	width: Math.max( $title.width(), $title_hover.width() ),
			//	height: Math.max( $title.outerHeight(), $title_hover.outerHeight() )
			//});

			$button.trigger( 'mpc.inited' );
		//}, 250 );
	}

	if ( typeof window.InlineShortcodeView != 'undefined' ) {
		var $body = $( 'body' );

		window.InlineShortcodeView_mpc_wc_add_to_cart = window.InlineShortcodeView.extend( {
			rendered: function() {
				var $button = this.$el.find( '.mpc-button' );

				$button.addClass( 'mpc-waypoint--init' );

				$body.trigger( 'mpc.icon-loaded', [ $button ] );
				$body.trigger( 'mpc.font-loaded', [ $button ] );
				$body.trigger( 'mpc.inited', [ $button ] );

				init_shortcode( $button );

				window.InlineShortcodeView_mpc_wc_add_to_cart.__super__.rendered.call( this );
			}
		} );
	}

	var $buttons = $( '.mpc-wc-add_to_cart' );

	$buttons.each( function() {
		var $button = $( this );

		$button.one( 'mpc.init', function () {
			init_shortcode( $button );
		} );

		$button.on( 'click', function( _ev ) {
			add_to_cart_call( _ev, $button );
		});
	} );
} )( jQuery );

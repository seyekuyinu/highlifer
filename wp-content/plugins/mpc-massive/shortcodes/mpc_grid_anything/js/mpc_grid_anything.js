/*----------------------------------------------------------------------------*\
	GRID ANYTHING SHORTCODE
\*----------------------------------------------------------------------------*/
( function( $ ) {
	"use strict";

	function wrap_shortcode( $grid ) {
		$grid.children().each( function() {
			$( this )
                .addClass( 'mpc-init--fast' )
				.wrap( '<div class="mpc-grid__item"><div class="mpc-grid__item-wrapper" /></div>' );
		});
	}

	function unwrap_shortcode( $grid ) {
		$grid.find( '.vc_element' ).each( function() {
			$( this ).unwrap().unwrap();
		});
	}

	function delay_init( $grid ) {
		if ( $.fn.isotope ) {
			init_shortcode( $grid );
		} else {
			setTimeout( function() {
				delay_init( $grid );
			}, 50 );
		}
	}

	function init_shortcode( $grid ) {
		var $row = $grid.parents( '.vc_row' );

		$grid.on( 'layoutComplete', function() {
			Waypoint.refreshAll();
		} );

		$grid.isotope( {
			itemSelector: '.mpc-grid__item',
			layoutMode: 'masonry'
		} );

		$row.on( 'mpc.rowResize', function() {
			if( $grid.data( 'isotope' ) ) {
				$grid.isotope( 'layout' );
			}
		} );

		$grid.trigger( 'mpc.inited' );
	}

	var $grids_anything = $( '.mpc-grid-anything' );

	$grids_anything.each( function() {
		var $grid_anything = $( this );

		wrap_shortcode( $grid_anything );

		$grid_anything.one( 'mpc.init', function() {
			delay_init( $grid_anything );
		} );
	});

} )( jQuery );

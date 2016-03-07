/*----------------------------------------------------------------------------*\
	PANEL
\*----------------------------------------------------------------------------*/

window.mpc_show_error = function() {
	var $error = jQuery( '#mpc_panel__error' );

	$error.addClass( 'mpc-visible' );
	setTimeout( function() {
		$error.removeClass( 'mpc-visible' );
	}, 3000 );
};

( function( $ ) {
	"use strict";

	var $panel         = $( '#mpc_panel' ),
		$panel_inputs  = $panel.find( ':input' ),
		$save_panel    = $( '#mpc_panel__save' ),
		$save_progress = $save_panel.find( '.mpc-progress' ),
		_wpnonce       = $( '#_wpnonce' ).val(),
		_is_saving     = false;

	$save_panel.on( 'click', function( event ) {
		event.preventDefault();

		if ( _is_saving ) {
			return;
		}

		_is_saving = true;
		$save_panel
			.removeClass( 'mpc-finished' )
			.addClass( 'mpc-working' );

		$save_progress
			.stop( true )
			.animate( {
				width: '90%'
			}, 2500, 'linear' );

		$.ajax( {
			url: ajaxurl,
			method: 'POST',
			data: {
				action: 'mpc_save_panel',
				options: $panel_inputs.serialize(),
				_wpnonce: _wpnonce
			}
		} ).always( function( response ) {
			if ( response != '0' ) {
				window.mpc_show_error();
			}

			$save_progress
				.stop( true )
				.animate( {
					width: '100%'
				}, {
					complete: function() {
						setTimeout( function() {
							_is_saving = false;

							$save_progress.animate( {
								left: '100%'
							}, {
								complete: function() {
									$save_panel
										.removeClass( 'mpc-working' )
										.addClass( 'mpc-finished' );

									$save_progress.css( {
										width: 0,
										left: 0
									} );

									setTimeout( function() {
										$save_panel.removeClass( 'mpc-finished' );
									}, 2500 );
								}
							} )
						}, 1000 );
					}
				} );
		} );
	} );

} )( jQuery );

/*----------------------------------------------------------------------------*\
	SHORTCODES
\*----------------------------------------------------------------------------*/

( function( $ ) {
	"use strict";

	function toggle_input( $checkbox, $shortcodes ) {
		var $value     = $checkbox.siblings( '.mpc-shortcode-value' ),
			_shortcode = $checkbox.attr( 'data-shortcode' ),
			_index     = 0,
			_subindex  = 0,
			_enabled   = false;

		if ( $checkbox.is( ':checked' ) ) {
			$value.val( 1 );

			if ( _enable_dependencies[ _shortcode ] !== undefined ) {
				for ( _index in _enable_dependencies[ _shortcode ] ) {
					$shortcodes.filter( '[data-shortcode="' + _enable_dependencies[ _shortcode ][ _index ] + '"]:not(:checked)' ).click();
				}
			}
		} else {
			$value.val( 0 );

			if ( _disable_dependencies[ _shortcode ] !== undefined ) {
				for ( _index in _disable_dependencies[ _shortcode ] ) {
					$shortcodes.filter( '[data-shortcode="' + _disable_dependencies[ _shortcode ][ _index ] + '"]:checked' ).click();
				}
			}
		}

		for ( _index in _multi_dependencies ) {
			_enabled = false;

			for ( _subindex in _multi_dependencies[ _index ] ) {
				if ( $shortcodes.filter( '[data-shortcode="' + _multi_dependencies[ _index ][ _subindex ] + '"]:checked' ).length > 0 ) {
					_enabled = true;
				}
			}

			if ( _enabled ) {
				$shortcodes.filter( '[data-shortcode="' +  _index + '"]:not(:checked)' ).click();
			} else {
				$shortcodes.filter( '[data-shortcode="' +  _index + '"]:checked' ).click();
			}
		}
	}

	var _enable_dependencies = {
		'mpc_accordion':            [ 'mpc_icon' ],
		'mpc_alert':                [ 'mpc_ribbon' ],
		'mpc_button':               [ 'mpc_tooltip' ],
		'mpc_button_set':           [ 'mpc_button', 'mpc_lightbox' ],
		'mpc_callout':              [ 'mpc_button', 'mpc_divider', 'mpc_ribbon' ],
		'mpc_carousel_anything':    [ 'mpc_navigation' ],
		'mpc_carousel_image':       [ 'mpc_navigation' ],
		'mpc_carousel_posts':       [ 'mpc_navigation', 'mpc_single_post' ],
		'mpc_carousel_slider':      [ 'mpc_navigation' ],
		'mpc_carousel_testimonial': [ 'mpc_navigation', 'mpc_testimonial' ],
		'mpc_circle_icons':         [ 'mpc_icon_column' ],
		'mpc_connected_icons':      [ 'mpc_icon_column' ],
		'mpc_counter':              [ 'mpc_icon', 'mpc_divider' ],
		'mpc_cubebox':              [ 'mpc_ribbon' ],
		'mpc_grid_posts':           [ 'mpc_pagination', 'mpc_single_post' ],
		'mpc_hotspot':              [ 'mpc_tooltip' ],
		'mpc_icon_column':          [ 'mpc_icon', 'mpc_divider' ],
		'mpc_icon_list':            [ 'mpc_icon' ],
		'mpc_ihover':               [ 'mpc_ihover_item' ],
		'mpc_interactive_image':    [ 'mpc_hotspot', 'mpc_ribbon' ],
		'mpc_image':                [ 'mpc_ribbon' ],
		'mpc_lightbox':             [ 'mpc_button', 'mpc_tooltip' ],
		'mpc_map':                  [ 'mpc_marker' ],
		'mpc_modal':                [ 'mpc_icon' ],
		'mpc_pricing_box':          [ 'mpc_button', 'mpc_navigation', 'mpc_pricing_column', 'mpc_pricing_legend' ],
		'mpc_quote':                [ 'mpc_ribbon' ],
		'mpc_single_post':          [ 'mpc_button' ],
		'mpc_tabs':                 [ 'mpc_button' ]
	};

	var _disable_dependencies = {
		'mpc_button':            [ 'mpc_callout', 'mpc_lightbox', 'mpc_pricing_box', 'mpc_single_post', 'mpc_tabs' ],
		'mpc_divider':           [ 'mpc_callout', 'mpc_counter', 'mpc_icon_column' ],
		'mpc_icon':              [ 'mpc_accordion', 'mpc_counter', 'mpc_icon_column', 'mpc_icon_list', 'mpc_modal' ],
		'mpc_icon_column':       [ 'mpc_circle_icons', 'mpc_connected_icons' ],
		'mpc_ihover':            [ 'mpc_ihover_item' ],
		'mpc_interactive_image': [ 'mpc_hotspot' ],
		'mpc_lightbox':          [ 'mpc_button' ],
		'mpc_map':               [ 'mpc_marker' ],
		'mpc_pricing_box':       [ 'mpc_pricing_column', 'mpc_pricing_legend' ],
		'mpc_single_post':       [ 'mpc_carousel_posts', 'mpc_grid_posts' ],
		'mpc_testimonial':       [ 'mpc_carousel_testimonial' ]
	};

	var _multi_dependencies = {
		'mpc_navigation': [ 'mpc_carousel_anything', 'mpc_carousel_image', 'mpc_carousel_posts', 'mpc_carousel_slider', 'mpc_carousel_testimonial', 'mpc_pricing_box' ],
		'mpc_pagination': [ 'mpc_grid_posts' ],
		'mpc_ribbon':     [ 'mpc_alert', 'mpc_callout', 'mpc_cubebox', 'mpc_image', 'mpc_interactive_image', 'mpc_quote' ],
		'mpc_tooltip':    [ 'mpc_button', 'mpc_hotspot', 'mpc_lightbox' ]
	};

	/* Field init */
	var $shortcodes_wrap = $( '.mpc-shortcodes' ),
		$shortcodes      = $shortcodes_wrap.find( '.mpc-shortcode:not(.mpc-all)' ),
		$all_shortcodes  = $shortcodes_wrap.find( '.mpc-all' ),
		_use_all         = $all_shortcodes.is( ':checked' ),
		_index           = 0;

	$shortcodes.parent().each( function() {
		var $shortcode    = $( this ),
			$list_enable  = $(),
			$list_disable = $(),
			_shortcode    = $shortcode.children( '.mpc-shortcode' ).attr( 'data-shortcode' );

		if ( _disable_dependencies[ _shortcode ] !== undefined ) {
			for ( _index in _disable_dependencies[ _shortcode ] ) {
				$list_disable = $list_disable.add( $shortcodes.filter( '[data-shortcode="' + _disable_dependencies[ _shortcode ][ _index ] + '"]' ).parent() );
			}
		}
		if ( _enable_dependencies[ _shortcode ] !== undefined ) {
			for ( _index in _enable_dependencies[ _shortcode ] ) {
				$list_enable = $list_enable.add( $shortcodes.filter( '[data-shortcode="' + _enable_dependencies[ _shortcode ][ _index ] + '"]' ).parent() );
			}
		}

		$shortcode.data( 'dependent-enable', $list_enable );
		$shortcode.data( 'dependent-disable', $list_disable );
	} );

	$all_shortcodes.on( 'click', function() {
		toggle_input( $( this ), $shortcodes );

		if ( $all_shortcodes.is( ':checked' ) ) {
			$shortcodes.prop( 'disabled', true );
			$shortcodes.parent().addClass( 'mpc-disabled' );

			_use_all = true;
		} else {
			$shortcodes.prop( 'disabled', false );
			$shortcodes.parent().removeClass( 'mpc-disabled' );

			_use_all = false;
		}
	} );

	$shortcodes.on( 'click', function() {
		var $shortcode = $( this );

		$shortcode.parent().toggleClass( 'mpc-active' );

		toggle_input( $shortcode, $shortcodes );
	} );

	$shortcodes.parent().on( 'mouseenter', function() {
		if ( _use_all ) {
			return;
		}

		$( this ).data( 'dependent-enable' ).addClass( 'mpc-dependent--enable' );
		$( this ).data( 'dependent-disable' ).addClass( 'mpc-dependent--disable' );
	} ).on( 'mouseleave', function() {
		if ( _use_all ) {
			return;
		}

		$shortcodes.parent().removeClass( 'mpc-dependent--enable mpc-dependent--disable' );
	} );

} )( jQuery );

/*----------------------------------------------------------------------------*\
	PRESETS
\*----------------------------------------------------------------------------*/

( function( $ ) {
	"use strict";

	function lazy_load( $images, _offset ) {
		var _inited   = false,
			_waypoint = $images.eq( _offset ).waypoint( {
				handler: function() {
					if ( _inited ) {
						return;
					} else {
						_inited = true;
					}

					$images.slice( _offset, _offset + 8 ).each( function() {
						var $image = $( this );

						$image.attr( 'src', $image.attr( 'data-src' ) );
					} );

					if ( $images.length > _offset ) {
						setTimeout( function() {
							lazy_load( $images, _offset + 8 );
						}, 250 );
					}
				},
				offset:  '100%'
			} );
	}

	var $shortcode_select = $( '#mpc_presets__select' ),
		$presets_list     = $( '#mpc_presets__list' ),
		$ajax             = $( '#mpc_presets__ajax' ),
		$controls         = $( '#mpc_presets__controls' ),
		$select_all       = $( '#mpc_presets__all' ),
		$select_none      = $( '#mpc_presets__none' ),
		$install          = $( '#mpc_presets__install' ),
		$install_progress = $install.find( '.mpc-progress' ),
		$batch_install    = $( '#mpc_presets__batch' ),
		$batch_progress   = $batch_install.find( '.mpc-progress' ),
		_default_image    = $( '#mpc_presets__default_img' ).val(),
		_preset_template  = $( '#mpc_templates__preset' ).html(),
		_wpnonce          = $( '#_wpnonce' ).val(),
		_shortcode        = '',
		_is_installing    = false,
		_wide_view        = [ 'mpc_accordion', 'mpc_alert', 'mpc_animated_text', 'mpc_button_set', 'mpc_callout', 'mpc_carousel_image', 'mpc_carousel_posts', 'mpc_carousel_slider', 'mpc_connected_icons', 'mpc_countdown', 'mpc_cubebox', 'mpc_grid_images', 'mpc_grid_posts', 'mpc_icon_list', 'mpc_ihover', 'mpc_mailchimp', 'mpc_modal', 'mpc_pricing_box', 'mpc_progress', 'mpc_quote', 'mpc_tabs', 'mpc_testimonial' ];

	_preset_template = _.template( _preset_template ? _preset_template : '' );

	$shortcode_select.on( 'change', function() {
		_shortcode = $shortcode_select.val();

		$presets_list.html( '' );
		$controls.addClass( 'mpc-hidden' );

		if ( _shortcode == '' ) {
			return;
		}

		if ( _wide_view.indexOf( _shortcode ) != -1 ) {
			$presets_list.addClass( 'mpc-wide-view' );
		} else {
			$presets_list.removeClass( 'mpc-wide-view' );
		}

		$shortcode_select.prop( 'disabled', true );
		$ajax.addClass( 'is-active' );

		$.ajax( {
			url: ajaxurl,
			data: {
				action:    'mpc_get_presets',
				shortcode: _shortcode,
				_wpnonce:  _wpnonce
			},
			dataType: 'json'
		} ).done( function( presets_list ) {
			$controls.removeClass( 'mpc-hidden' );

			for ( var _preset in presets_list ) {
				$presets_list.append( _preset_template( presets_list[ _preset ] ) );
			}

			var $images = $presets_list.find( '.mpc-preset > img' );

			lazy_load( $images, 0 );

			//$presets_list.imagesLoaded().always( function() {
			//	var $images = $presets_list.find( '.mpc-preset > img' );
			//
			//	if ( $images.length && $images.first().attr( 'src' ).split('.').pop() == 'gif' ) {
			//		$images.each( function( index ) {
			//			var $image = $( this ),
			//				_src = $image.attr( 'src' );
			//
			//			$image.attr( 'src', _default_image );
			//
			//			setTimeout( function() {
			//				$image.attr( 'src', _src );
			//			}, +index * 10 );
			//		} );
			//	}
			//} );
		} ).fail( function() {
			window.mpc_show_error();
		} ).always( function() {
			$shortcode_select.prop( 'disabled', false );
			$ajax.removeClass( 'is-active' );
		} );
	} );

	$select_all.on( 'click', function( event ) {
		event.preventDefault();

		$presets_list.find( '.mpc-preset' ).addClass( 'mpc-active' );
		$install.removeClass( 'mpc-disabled' );
	} );

	$select_none.on( 'click', function( event ) {
		event.preventDefault();

		$presets_list.find( '.mpc-preset' ).removeClass( 'mpc-active' );
		$install.addClass( 'mpc-disabled' );
	} );

	$presets_list.on( 'click', '.mpc-preset', function() {
		var $preset = $( this );

		$preset.toggleClass( 'mpc-active' );

		if ( $presets_list.find( '.mpc-active' ).length ) {
			$install.removeClass( 'mpc-disabled' );
		} else {
			$install.addClass( 'mpc-disabled' );
		}
	} );

	$batch_install.on( 'click', function( event ) {
		event.preventDefault();

		if ( _is_installing ) {
			return;
		}

		if ( ! confirm( $batch_install.attr( 'data-message' ) ) ) {
			return;
		}

		_is_installing = true;
		$batch_install
			.removeClass( 'mpc-finished' )
			.addClass( 'mpc-working' );

		$batch_progress
			.stop( true )
			.animate( {
				width: '90%'
			}, 90000, 'linear' );

		$.ajax( {
			url: ajaxurl,
			data: {
				action:   'mpc_install_all_presets',
				_wpnonce: _wpnonce
			}
		} ).always( function( response ) {
			if ( response != '0' ) {
				window.mpc_show_error();
			}

			$batch_progress
				.stop( true )
				.animate( {
					width: '100%'
				}, {
					complete: function() {
						setTimeout( function() {
							_is_installing = false;

							$batch_progress.animate( {
								left: '100%'
							}, {
								complete: function() {
									$batch_install
										.removeClass( 'mpc-working' )
										.addClass( 'mpc-finished' );

									$batch_progress.css( {
										width: 0,
										left: 0
									} );

									setTimeout( function() {
										$batch_install.removeClass( 'mpc-finished' );
									}, 2500 );
								}
							} )
						}, 1000 );
					}
				} );
		} );
	} );

	$install.on( 'click', function( event ) {
		event.preventDefault();

		if ( _is_installing ) {
			return;
		}

		var $selected = $presets_list.find( '.mpc-active' ),
			_presets = [];

		if ( $selected.filter( '.mpc-installed' ).length && ! confirm( $install.attr( 'data-message' ) ) ) {
			return;
		}

		if ( $selected.length ) {
			$selected.each( function() {
				_presets.push( $( this ).attr( 'data-preset' ) );
			} );

			_is_installing = true;
			$install
				.removeClass( 'mpc-finished' )
				.addClass( 'mpc-working' );

			$install_progress
				.stop( true )
				.animate( {
					width: '90%'
				}, 10000, 'linear' );

			$.ajax( {
				url: ajaxurl,
				data: {
					action:    'mpc_install_presets',
					shortcode: $shortcode_select.val(),
					presets:   _presets,
					_wpnonce:  _wpnonce
				}
			} ).always( function( response ) {
				if ( response != '0' ) {
					window.mpc_show_error();
				}

				$install_progress
					.stop( true )
					.animate( {
						width: '100%'
					}, {
						complete: function() {
							setTimeout( function() {
								_is_installing = false;

								$selected.addClass( 'mpc-installed' );

								$install_progress.animate( {
									left: '100%'
								}, {
									complete: function() {
										$select_none.trigger( 'click' );

										$install
											.removeClass( 'mpc-working' )
											.addClass( 'mpc-finished' );

										$install_progress.css( {
											width: 0,
											left: 0
										} );

										setTimeout( function() {
											$install.removeClass( 'mpc-finished' );
										}, 2500 );
									}
								} )
							}, 1000 );
						}
					} );
			} );
		}
	} )
} )( jQuery );

/*----------------------------------------------------------------------------*\
	SYSTEM INFO
\*----------------------------------------------------------------------------*/

( function( $ ) {
	"use strict";

	var $show      = $( '#mpc_panel__show_info' ),
		$info_wrap = $( '#mpc_panel__system_wrap' ),
		$info_file = $( '#mpc_panel__info_file' ),
		$info_text = $info_wrap.find( 'textarea' ),
		_wpnonce   = $( '#_wpnonce' ).val(),
		_info      = $info_text.val();

	$show.on( 'click', function() {
		$info_wrap.css( 'max-height', 250 );

		setTimeout( function() {
			$info_wrap.css( 'max-height', '' );
		}, 250 );
	} );

	$info_file.on( 'click', function() {
		location.href = ajaxurl + '?action=mpc_export_info&_wpnonce=' + _wpnonce + '&system_info=' + escape( _info );
	} );

	$info_text.on( 'click', function() {
		$info_text.select();
	} );
} )( jQuery );

/*----------------------------------------------------------------------------*\
	TOOLBOX
\*----------------------------------------------------------------------------*/

( function( $ ) {
	"use strict";

	var $export  = $( '#mpc_panel__export' );

	$export.on( 'click', function( event ) {
		event.preventDefault();

		$.ajax( {
			url: ajaxurl,
			data: {
				action: 'mpc_export_presets'
			}
		} ).done( function( response ) {
			//console.log( response );
		} );
	} );
} )( jQuery );
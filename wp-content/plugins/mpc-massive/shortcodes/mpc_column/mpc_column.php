<?php
/*----------------------------------------------------------------------------*\
	COLUMN SHORTCODE
\*----------------------------------------------------------------------------*/

if ( ! class_exists( 'MPC_Column' ) ) {
	class MPC_Column {
		public $shortcode      = 'vc_column';
		public $shortcode_path = '/shortcodes/mpc_column/';
		public $panel_section  = array();

		function __construct() {
			add_filter( 'vc_shortcode_set_template_vc_column', array( $this, 'override_template' ) );
			add_filter( 'vc_shortcode_set_template_vc_column_inner', array( $this, 'override_template' ) );

			add_action( 'init', array( $this, 'shortcode_map' ) );
		}

		/* Enqueue all styles/scripts required by shortcode */
		function enqueue_shortcode_scripts() {
			wp_enqueue_style( 'mpc_column-css', MPC_MASSIVE_URL . '/shortcodes/mpc_column/css/mpc_column.css', array(), MPC_MASSIVE_VERSION );
			wp_enqueue_script( 'mpc_column-js', MPC_MASSIVE_URL . '/shortcodes/mpc_column/js/mpc_column' . MPC_MASSIVE_MIN . '.js', array( 'jquery' ), MPC_MASSIVE_VERSION );
		}

		/* Return shortcode markup for display */
		function override_template() {
			global $mpc_ma_options;
			if ( $mpc_ma_options[ 'single_js_css' ] !== '1' ) {
				$this->enqueue_shortcode_scripts();
			}

			return MPC_MASSIVE_DIR . '/shortcodes/mpc_column/vc_column.php';
		}

		/* Generate shortcode styles */
		function shortcode_styles( $styles ) {
			global $mpc_massive_styles;
			$css_id = uniqid( 'mpc_column-' . rand( 1, 100 ) );
			$style  = '';

			if ( $styles[ 'alignment' ] != '' ) {
				$style .= '.vc_column_container[data-column-id="' . $css_id . '"] {';
					$style .= 'text-align: ' . $styles[ 'alignment' ] . ';';
				$style .= '}';
			}

			$mpc_massive_styles .= $style;

			return $css_id;
		}

		/* Map all shortcode options to Visual Composer popup */
		function shortcode_map() {
			if ( ! function_exists( 'vc_add_params' ) ) {
				return;
			}

			/* Column */
			$link_params = array(
				array(
					'type'        => 'vc_link',
					'heading'     => __( 'Link', 'mpc' ),
					'param_name'  => 'url',
					'value'       => '',
					'description' => __( 'Specify URL.', 'mpc' ),
					'weight'      => 1,
				),
				array(
					'type'             => 'checkbox',
					'heading'          => __( 'Enable Sticky Column', 'mpc' ),
					'param_name'       => 'enable_sticky',
					'value'            => array( __( 'Yes', 'mpc' ) => 'true' ),
					'std'              => '',
					'description'      => __( 'Enable Sticky Column.', 'mpc' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'mpc_text',
					'heading'          => __( 'Top Offset', 'mpc' ),
					'param_name'       => 'sticky_offset',
					'value'            => 0,
					'addon'            => array(
						'icon'  => 'dashicons dashicons-arrow-down-alt',
						'align' => 'prepend',
					),
					'label'            => 'px',
					'validate'         => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column mpc-clear--both',
					'dependency'       => array(
						'element' => 'enable_sticky',
						'value'   => 'true'
					),
				),
				array(
					'type'             => 'dropdown',
					'heading'          => __( 'Content Alignment', 'mpc' ),
					'param_name'       => 'alignment',
					'value'            => array(
						__( 'Default', 'mpc' ) => '',
						__( 'Left', 'mpc' )    => 'left',
						__( 'Center', 'mpc' )  => 'center',
						__( 'Right', 'mpc' )   => 'right',
						__( 'Justify', 'mpc' ) => 'justify',
					),
					'std'              => '',
					'description'      => __( 'Specify custom alignment for column content.', 'mpc' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
			);

			$animation = MPC_Snippets::vc_animation();

			$params = array_merge( $link_params, $animation );

			if ( function_exists( 'vc_lean_map' ) ) {
				$column_settings = require( vc_path_dir( 'CONFIG_DIR' ) . '/containers/shortcode-vc-column.php' );

				$extend_column_settings = array(
					'params' => array_merge( $column_settings[ 'params' ], $params ),
				);

				vc_map_update( 'vc_column', $extend_column_settings );
				vc_map_update( 'vc_column_inner', $extend_column_settings );
			} else {
				vc_add_params( $this->shortcode, $params );
			}
		}
	}
}

if ( class_exists( 'MPC_Column' ) ) {
	global $MPC_Column;
	$MPC_Column = new MPC_Column();
}
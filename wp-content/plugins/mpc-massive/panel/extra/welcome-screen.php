<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MPC_Setup_Wizard {
	private $step    = '';
	private $steps   = array();
	private $options = array();

	public function __construct() {
		if ( apply_filters( 'mpc_enable_setup_wizard', true ) && current_user_can( 'manage_options' ) ) {
			add_action( 'admin_menu', array( $this, 'admin_menus' ) );
			add_action( 'admin_init', array( $this, 'setup_wizard' ) );

			$this->options = get_option( 'mpc_ma_options' );
		}
	}

	public function admin_menus() {
		add_dashboard_page( '', '', 'manage_options', 'ma-setup', '' );
	}

	public function setup_wizard() {
		if ( empty( $_GET[ 'page' ] ) || 'ma-setup' !== $_GET[ 'page' ] ) {
			return;
		}

		$this->steps = array(
			'introduction' => array(
				'name'    =>  __( 'Welcome', 'mpc' ),
				'view'    => array( $this, 'mpc_setup_introduction' ),
				'handler' => ''
			),
			'settings' => array(
				'name'    =>  __( 'Settings', 'mpc' ),
				'view'    => array( $this, 'mpc_setup_settings' ),
				'handler' => array( $this, 'mpc_setup_settings_save' )
			),
			'presets' => array(
				'name'    =>  __( 'Presets', 'mpc' ),
				'view'    => array( $this, 'mpc_setup_presets' ),
				'handler' => array( $this, 'mpc_setup_presets_save' )
			),
			'ready' => array(
				'name'    =>  __( 'Ready!', 'mpc' ),
				'view'    => array( $this, 'mpc_setup_ready' ),
				'handler' => ''
			)
		);

		$this->step = isset( $_GET[ 'step' ] ) ? sanitize_key( $_GET[ 'step' ] ) : current( array_keys( $this->steps ) );

		wp_enqueue_style( 'ma-setup-css', MPC_MASSIVE_URL . '/assets/css/admin/mpc-welcome.css', array( 'dashicons', 'install' ), MPC_MASSIVE_VERSION );

		wp_register_script( 'ma-setup-js', MPC_MASSIVE_URL . '/assets/js/mpc-welcome.js', array( 'jquery' ), MPC_MASSIVE_VERSION );

		wp_enqueue_style( 'mpc-panel-css', MPC_MASSIVE_URL . '/assets/css/mpc-panel.css' );

		wp_enqueue_script( 'mpc-panel-waypoints-js', MPC_MASSIVE_URL . '/assets/js/vendor/waypoints.base.min.js', array( 'jquery' ), MPC_MASSIVE_VERSION, true );

		wp_register_script( 'mpc-panel-js', MPC_MASSIVE_URL . '/assets/js/mpc-panel.js', array( 'jquery', 'underscore', 'mpc-panel-waypoints-js' ), MPC_MASSIVE_VERSION );

		if ( ! empty( $_POST[ 'save_step' ] ) && isset( $this->steps[ $this->step ][ 'handler' ] ) ) {
			call_user_func( $this->steps[ $this->step ][ 'handler' ] );
		}

		ob_start();
		$this->setup_wizard_header();
		$this->setup_wizard_steps();
		$this->setup_wizard_content();
		$this->setup_wizard_footer();
		exit;
	}

	public function get_next_step_link() {
		$keys = array_keys( $this->steps );
		return add_query_arg( 'step', $keys[ array_search( $this->step, array_keys( $this->steps ) ) + 1 ] );
	}

	public function setup_wizard_header() {
		?>
		<!DOCTYPE html>
		<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
		<head>
			<meta name="viewport" content="width=device-width" />
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title><?php _e( 'Massive Addons &rsaquo; Setup Wizard', 'mpc' ); ?></title>
			<?php //wp_print_scripts( 'ma-setup-js' ); ?>
			<?php do_action( 'admin_print_styles' ); ?>
			<?php do_action( 'admin_head' ); ?>
		</head>
		<body class="ma-setup ma-step-<?php echo $this->step ?> wp-core-ui">
		<h1 id="ma-logo"><a href="http://mpcreation.net"><img src="<?php echo MPC_MASSIVE_URL; ?>/assets/images/logo_dark.png" alt="Massive Addons" /></a></h1>
		<?php
	}

	public function setup_wizard_footer() {
		?>
		<?php if ( 'ready' != $this->step ) : ?>
			<a class="ma-return-to-dashboard" href="<?php echo esc_url( admin_url() ); ?>"><?php _e( 'Return to the WordPress Dashboard', 'mpc' ); ?></a>
		<?php endif; ?>
		<?php if ( isset( $_GET[ 'step' ] ) && sanitize_key( $_GET[ 'step' ] ) === 'presets' ) {
			echo '<script> var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '";</script>';
			//wp_print_scripts( 'mpc-panel-js' );
			wp_print_scripts( 'mpc-panel-vendor-js' );
			wp_print_scripts( 'mpc-panel-js' );
		} ?>

		<?php wp_print_scripts( 'ma-setup-js' ); ?>
		</body>
		</html>
		<?php
	}

	public function setup_wizard_steps() {
		$output_steps = $this->steps;
		?>
		<ol class="ma-setup-steps">
			<?php foreach ( $output_steps as $step_key => $step ) : ?>
				<li class="<?php
				if ( $step_key === $this->step ) {
					echo 'active';
				} elseif ( array_search( $this->step, array_keys( $this->steps ) ) > array_search( $step_key, array_keys( $this->steps ) ) ) {
					echo 'done';
				}
				?>"><?php echo esc_html( $step['name'] ); ?></li>
			<?php endforeach; ?>
		</ol>
		<?php
	}

	public function setup_wizard_content() {
		echo '<div class="ma-setup-content">';
		call_user_func( $this->steps[ $this->step ]['view'] );
		echo '</div>';
	}

	public function mpc_setup_introduction() {
		?>
		<h1><?php _e( 'Welcome to the Massive Addons journey!', 'mpc' ); ?></h1>
		<div class="mpc-wrap">
			<p><?php _e( 'Thank you for choosing Massive Addons to power your amazing website! This quick setup wizard will help you configure the basic settings. <strong>It\'s completely optional and shouldn\'t take longer than five minutes.</strong>', 'mpc' ); ?></p>
			<p><?php _e( 'No time right now? If you don\'t want to go through the wizard, you can skip and return to the WordPress dashboard. Come back anytime if you change your mind!', 'mpc' ); ?></p>
			<p class="ma-setup-actions step">
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next"><?php _e( 'Let\'s Go!', 'mpc' ); ?></a>
				<a href="<?php echo esc_url( wp_get_referer() ? wp_get_referer() : admin_url( 'plugins.php' ) ); ?>" class="button button-large"><?php _e( 'Not right now', 'mpc' ); ?></a>
			</p>
		</div>
		<?php
	}

	public function mpc_setup_settings() {
		$options = get_option( 'mpc_ma_options' );
		?>
		<h1><?php _e( 'Basic Settings', 'mpc' ); ?></h1>
		<div class="mpc-wrap">
			<form method="post">
				<p><?php printf( __( 'You can change the basic options right here. They are also available all the time at %sMassive Panel%s.', 'mpc' ), '<a href="' . esc_url( admin_url( 'admin.php?page=ma-panel' ) ) . '" target="_blank">', '</a>' ); ?></p>

				<div class="mpc-option">
					<label class="mpc-option-state">
						<input type="checkbox" class="checkbox mpc-easy_mode" id="easy_mode" name="easy_mode" value="1" <?php checked( $options[ 'easy_mode' ], '1' ); ?>>
						<span class="mpc-switch"><span class="mpc-state--on"><?php _e( 'on', 'mpc' ); ?></span><span class="mpc-thumb"></span><span class="mpc-state--off"><?php _e( 'off', 'mpc' ); ?></span></span>
					</label>
					<span class="mpc-option-name"><?php _e( 'Easy Mode', 'mpc' ); ?></span>
				</div>

				<div class="mpc-option">
					<label class="mpc-option-state">
						<input type="checkbox" class="checkbox mpc-animations_on_mobile" id="animations_on_mobile" name="animations_on_mobile" value="1" <?php checked( $options[ 'animations_on_mobile' ], '1' ); ?>>
						<span class="mpc-switch"><span class="mpc-state--on"><?php _e( 'on', 'mpc' ); ?></span><span class="mpc-thumb"></span><span class="mpc-state--off"><?php _e( 'off', 'mpc' ); ?></span></span>
					</label>
					<span class="mpc-option-name"><?php _e( 'Animations on Mobile', 'mpc' ); ?></span>
				</div>

				<div class="mpc-option">
					<label class="mpc-option-state">
						<input type="checkbox" class="checkbox mpc-single_js_css" id="single_js_css" name="single_js_css" value="1" <?php checked( $options[ 'single_js_css' ], '1' ); ?>>
						<span class="mpc-switch"><span class="mpc-state--on"><?php _e( 'on', 'mpc' ); ?></span><span class="mpc-thumb"></span><span class="mpc-state--off"><?php _e( 'off', 'mpc' ); ?></span></span>
					</label>
					<span class="mpc-option-name"><?php _e( 'Single JS/CSS file for All Shortcodes', 'mpc' ); ?></span>
				</div>

				<div class="mpc-option">
					<label class="mpc-option-state">
						<input type="checkbox" class="checkbox mpc-vc_row_addons" id="vc_row_addons" name="vc_row_addons" value="1" <?php checked( $options[ 'vc_row_addons' ], '1' ); ?>>
						<span class="mpc-switch"><span class="mpc-state--on"><?php _e( 'on', 'mpc' ); ?></span><span class="mpc-thumb"></span><span class="mpc-state--off"><?php _e( 'off', 'mpc' ); ?></span></span>
					</label>
					<span class="mpc-option-name"><?php _e( 'Row/Column Addons (separator, overlay, toggle, animation)', 'mpc' ); ?></span>
				</div>

				<div class="mpc-option">
					<label class="mpc-option-state">
						<input type="checkbox" class="checkbox mpc-magnific_popup" id="magnific_popup" name="magnific_popup" value="1" <?php checked( $options[ 'magnific_popup' ], '1' ); ?>>
						<span class="mpc-switch"><span class="mpc-state--on"><?php _e( 'on', 'mpc' ); ?></span><span class="mpc-thumb"></span><span class="mpc-state--off"><?php _e( 'off', 'mpc' ); ?></span></span>
					</label>
					<span class="mpc-option-name"><?php _e( 'Use Magnific Popup instead of old PrettyPhoto', 'mpc' ); ?></span>
				</div>

				<p class="ma-setup-actions step">
					<input type="submit" class="button-primary button button-large button-next" value="<?php esc_attr_e( 'Continue', 'mpc' ); ?>" name="save_step" />
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php _e( 'Skip this step', 'mpc' ); ?></a>
					<?php wp_nonce_field( 'mpc-ma-panel' ); ?>
				</p>
			</form>
		</div>
		<?php
	}

	public function mpc_setup_settings_save() {
		check_admin_referer( 'mpc-ma-panel' );

		$this->options[ 'easy_mode' ] = isset( $_POST[ 'easy_mode' ] ) ? $_POST[ 'easy_mode' ] : '0';
		$this->options[ 'animations_on_mobile' ] = isset( $_POST[ 'animations_on_mobile' ] ) ? $_POST[ 'animations_on_mobile' ] : '0';
		$this->options[ 'single_js_css' ] = isset( $_POST[ 'single_js_css' ] ) ? $_POST[ 'single_js_css' ] : '0';
		$this->options[ 'vc_row_addons' ] = isset( $_POST[ 'vc_row_addons' ] ) ? $_POST[ 'vc_row_addons' ] : '0';
		$this->options[ 'magnific_popup' ] = isset( $_POST[ 'magnific_popup' ] ) ? $_POST[ 'magnific_popup' ] : '0';

		update_option( 'mpc_ma_options', $this->options );

		wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
		exit;
	}

	public function mpc_setup_presets() {
		global $MPC_Panel;
		?>
		<h1><?php _e( 'Presets Setup', 'mpc' ); ?></h1>
		<div class="mpc-wrap">
			<form method="post" class="mpc-panel">
				<div class="mpc-presets">
					<div class="mpc-presets__header">
						<p><?php _e( '<strong>Install all shortcodes presets at once (recommended)</strong> or select a shortcode and install only the presets you like.', 'mpc' ); ?></p>
						<a href="#batch" id="mpc_presets__batch" class="mpc-presets__batch mpc-panel__primary" data-message="<?php _e( 'Any previously installed preset will be overwritten. Are you sure you want to continue?', 'mpc' ); ?>">
							<span class="mpc-default"><?php _e( 'Install all', 'mpc' ); ?></span>
							<span class="mpc-working"><?php _e( 'Installing...', 'mpc' ); ?></span>
							<span class="mpc-finished"><?php _e( 'Installed :)', 'mpc' ); ?></span>
							<span class="mpc-batch__progress mpc-progress"></span>
						</a>
						<span class="mpc-separator">or</span>
						<select id="mpc_presets__select" class="mpc-presets-select">
							<option value=""><?php _e( 'Select Shortcode', 'mpc' ); ?></option>
							<?php foreach ( $MPC_Panel->presets_list as $shortcode => $name ) : ?>
								<option value="<?php echo esc_attr( $shortcode ); ?>"><?php echo $name; ?></option>
							<?php endforeach; ?>
						</select>
						<div id="mpc_presets__ajax" class="mpc-presets__ajax mpc-ajax"><div><span></span><span></span><span></span></div></div>
						<div id="mpc_presets__controls" class="mpc-presets__controls mpc-hidden">
							<a href="#all" id="mpc_presets__all" class="mpc-presets__all button"><?php _e( 'Select all', 'mpc' ); ?></a>
							<a href="#none" id="mpc_presets__none" class="mpc-presets__none button"><?php _e( 'Select none', 'mpc' ); ?></a>
							<a href="#install" id="mpc_presets__install" class="mpc-presets__install mpc-panel__primary mpc-disabled" data-message="<?php _e( 'Re-installing presets will overwrite their settings. Are you sure you want to continue?', 'mpc' ); ?>">
								<span class="mpc-default"><?php _e( 'Install selected', 'mpc' ); ?></span>
								<span class="mpc-working"><?php _e( 'Installing...', 'mpc' ); ?></span>
								<span class="mpc-finished"><?php _e( 'Installed :)', 'mpc' ); ?></span>
								<span class="mpc-install__progress mpc-progress"></span>
							</a>
						</div>
					</div>
					<div id="mpc_presets__list" class="mpc-presets__list"></div>
				</div>

				<div class="mpc-description">
					<p><?php _e( 'Presets with <span class="mpc-installed-badge mpc-mini"><i class="dashicons dashicons-yes"></i></span> badge are already installed. Please note that re-installing presets will overwrite their options.', 'mpc' ); ?></p>
					<p><?php _e( '<em>Please be aware that installation make take a while. It automatically downloads images used in presets.</em>', 'mpc' ); ?></p>
				</div>

				<p class="ma-setup-actions step">
					<input type="submit" class="button-primary button button-large button-next" value="<?php esc_attr_e( 'Continue', 'mpc' ); ?>" name="save_step" />
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php _e( 'Skip this step', 'mpc' ); ?></a>
					<?php wp_nonce_field( 'mpc-ma-panel' ); ?>
				</p>

				<script id="mpc_templates__preset" type="text/template" >
					<div class="mpc-preset<% if ( is_installed ) { %> mpc-installed<% } %>" data-preset="<%= preset %>">
						<% if ( url ) { %><img src="<?php echo MPC_MASSIVE_URL . '/assets/images/mpc-image-placeholder.png'; ?>" data-src="<%= url %>" width="240" height="100" alt="<?php _e( 'Preset', 'mpc' ); ?>"><% } %>
						<p><%= title %></p>
						<div class="mpc-installed-badge"><i class="dashicons dashicons-yes"></i></div>
					</div>
				</script>
			</form>
		</div>
		<?php
	}

	public function mpc_setup_presets_save() {
		check_admin_referer( 'mpc-ma-panel' );

		wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
		exit;
	}

	private function mpc_setup_ready_actions() {
		delete_transient( 'mpc_setup_wizard' );
	}

	public function mpc_setup_ready() {
		$this->mpc_setup_ready_actions();
		?>
		<h1><?php _e( 'Massive Addons are ready to use!', 'mpc' ); ?> <i class="dashicons dashicons-smiley"></i></h1>
		<div class="mpc-wrap">

			<div class="ma-setup-next-steps">
				<div class="ma-setup-next-steps-first">
					<h2><?php _e( 'Next Steps', 'mpc' ); ?></h2>
						<a class="ma-last-button ma-return-to-dashboard--final" href="<?php echo esc_url( admin_url() ); ?>"><?php _e( 'Create something awesome!', 'mpc' ); ?></a>
					<?php if ( get_template() == 'bober' ) : ?>
						<a class="ma-last-button ma-theme-panel" href="<?php echo esc_url( admin_url( 'admin.php?page=ThemePanel' ) ); ?>"><?php _e( 'Setup Bober Theme', 'mpc' ); ?></a>
					<?php endif; ?>
				</div>
				<div class="ma-setup-next-steps-last">
					<h2><?php _e( 'Useful Links', 'mpc' ); ?></h2>
					<ul>
						<li>
							<i class="dashicons dashicons-book"></i>
							<a href="http://hub.mpcreation.net/section/massive_addons/" target="_blank"><?php _e( 'Knowledge Base', 'mpc' ); ?></a>
						</li>
						<li>
							<i class="dashicons dashicons-video-alt3"></i>
							<a href="https://www.youtube.com/watch?v=9NBfVPpYYTk&list=PLnkqmxp7KlX4qUPjRjv2of3SQM2xeOSYN" target="_blank"><?php _e( 'Video Tutorials', 'mpc' ); ?></a>
						</li>
						<li>
							<i class="dashicons dashicons-sos"></i>
							<a href="https://mpc.ticksy.com/" target="_blank"><?php _e( 'Support Site', 'mpc' ); ?></a>
						</li>
						<li>
							<i class="dashicons dashicons-facebook-alt"></i>
							<a href="https://www.facebook.com/massivepixelcreation" target="_blank"><?php _e( 'Like us on Facebook', 'mpc' ); ?></a>
						</li>
						<li>
							<i class="dashicons dashicons-twitter"></i>
							<a href="ttps://twitter.com/mpcreation" target="_blank"><?php _e( 'Follow us on Twitter', 'mpc' ); ?></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<?php
	}
}

new MPC_Setup_Wizard();

<?php
/**
 * Enqueue Assets, styles & scripts
 *
 * @package  PluginStarter\Assets
 *
 * @since    v1.0.0
 */

namespace EasyPoll\Assets;

use EasyPoll;
use EasyPoll\Settings\Options;
use EasyPoll\Utilities\Utilities;

/**
 * Enqueue styles & scripts
 */
class Enqueue {

	/**
	 * Register hooks
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'load_admin_scripts' ) );
		// Frontend scripts.
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'load_front_end_scripts' ) );

		// Set up script translation.
		add_action( 'admin_enqueue_scripts', __CLASS__ . '::backend_translation' );
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::frontend_translation' );

		// Remove admin notices.
		add_action( 'admin_init', __CLASS__ . '::remove_all_notices' );
		add_filter( 'admin_footer_text', __CLASS__ . '::admin_footer_text' );
	}

	/**
	 * Load admin styles & scripts
	 *
	 * @return void
	 */
	public static function load_admin_scripts(): void {
		$plugin_data = EasyPoll::plugin_data();
		$post_type   = get_post_type();
		$page        = isset( $_GET['page'] ) ? sanitize_title( wp_unslash( $_GET['page'] ) ) : '';

		// load styles & scripts only required page.
		if ( 'easy-poll' === $post_type || 'ep-settings' === $page || 'ep-report' === $page ) {
			wp_enqueue_style( 'ep-backend-style', $plugin_data['assets'] . 'bundles/backend-style.min.css', array(), filemtime( $plugin_data['plugin_path'] . 'assets/bundles/backend-style.min.css' ) );

			wp_enqueue_script( 'ep-backend-script', $plugin_data['assets'] . 'bundles/backend.min.js', array( 'wp-i18n' ), filemtime( $plugin_data['plugin_path'] . 'assets/bundles/backend.min.js' ), true );

			// add data to use in js files.
			wp_add_inline_script( 'ep-backend-script', 'const epData = ' . json_encode( self::scripts_data() ), 'before' );
		}

		/**
		 * On the backend report page enqueue chart js
		 *
		 * @since 1.2.0
		 */
		if ( 'ep-report' === $page ) {
			self::enqueue_chart_js();
		}

		self::common_scripts();
	}

	/**
	 * Enqueue frontend scripts & styles
	 *
	 * @since v1.0.0
	 *
	 * @return void
	 */
	public static function load_front_end_scripts(): void {
		$plugin_data = EasyPoll::plugin_data();

		/**
		 * Front end scripts & styles are not loading conditionally
		 * because by short code poll could be use anywhere. In this
		 * case we need scripts & styles everywhere to work.
		 */
		wp_enqueue_style( 'ep-frontend-style', $plugin_data['assets'] . 'bundles/frontend-style.min.css', array(), filemtime( $plugin_data['plugin_path'] . 'assets/bundles/frontend-style.min.css' ) );

		wp_enqueue_script( 'ep-frontend-script', $plugin_data['assets'] . 'bundles/frontend.min.js', array( 'wp-i18n' ), filemtime( $plugin_data['plugin_path'] . 'assets/bundles/frontend.min.js' ), true );

		// Add data to use in js files.
		wp_add_inline_script( 'ep-frontend-script', 'const epData = ' . json_encode( self::scripts_data() ), 'before' );

		self::common_scripts();
	}

	/**
	 * Add inline data in scripts
	 *
	 * @return array
	 */
	public static function scripts_data() {
		$plugin_data = EasyPoll::plugin_data();
		$data        = array(
			'url'                 => admin_url( 'admin-ajax.php' ),
			'nonce'               => wp_create_nonce( $plugin_data['nonce'] ),
			'nonce_action'        => $plugin_data['nonce_action'],
			'success_msg'         => Options::get_option( 'ep-success-message' ),
			'poll_template_width' => Options::get_option( 'ep-max-width' ),
		);
		return apply_filters( 'ep_inline_script_data', $data );
	}

	/**
	 * Script text domain
	 *
	 * @return void
	 */
	public static function backend_translation() {
		$plugin_data = EasyPoll::plugin_data();

		wp_set_script_translations( 'ep-backend-scripts', $plugin_data['plugin_path'] . 'languages/' );
	}

	/**
	 * Front end Script text domain
	 *
	 * @return void
	 */
	public static function frontend_translation() {
		$plugin_data = EasyPoll::plugin_data();

		wp_set_script_translations( 'ep-frontend-scripts', $plugin_data['plugin_path'] . 'languages/' );
	}

	/**
	 * Enqueue chart js scripts
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	public static function enqueue_chart_js() {
		$plugin_data = EasyPoll::plugin_data();
		// Plugin min script.
		wp_enqueue_script(
			'ep-chart',
			$plugin_data['assets'] . 'lib/chart/chart.js',
			array(),
			filemtime( $plugin_data['plugin_path'] . 'assets/lib/chart/chart.js' ),
			true
		);
		// Chart config script.
		wp_enqueue_script(
			'ep-chart-config',
			$plugin_data['assets'] . 'lib/chart/chart-config.js',
			array(),
			filemtime( $plugin_data['plugin_path'] . 'assets/lib/chart/chart-config.js' ),
			true
		);
	}

	/**
	 * Enqueue common scripts & styles
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	public static function common_scripts() {
		$plugin_data = EasyPoll::plugin_data();

		wp_enqueue_style( 'ep-common-style', $plugin_data['assets'] . 'bundles/common-style.min.css', array(), filemtime( $plugin_data['plugin_path'] . 'assets/bundles/common-style.min.css' ) );
	}

	/**
	 * Remove all admin notices
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	public static function remove_all_notices() {
		$current_page = Utilities::sanitize_get_field( 'page' );
		if ( 'ep-report' === $current_page || 'ep-settings' === $current_page ) {
			remove_all_actions( 'admin_notices' );
		}
	}

	/**
	 * Modify admin footer text
	 *
	 * @since 1.2.0
	 *
	 * @param string $text default text.
	 *
	 * @return string
	 */
	public static function admin_footer_text( $text ) {
		$current_page = Utilities::sanitize_get_field( 'page' );
		$post_type    = Utilities::sanitize_get_field( 'post_type' );
		if ( 'ep-report' === $current_page || 'ep-settings' === $current_page || 'easy-poll' === $post_type ) {
			$text = 'If you like <strong>Easy Poll</strong>. Please consider <a href="https://www.buymeacoffee.com/shewa" target="_blank">donating</a> to support the future development and maintenance of this plugin.';
		}
		return $text;
	}
}

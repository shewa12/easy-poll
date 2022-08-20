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
	}

	/**
	 * Load admin styles & scripts
	 *
	 * @return void
	 */
	public static function load_admin_scripts(): void {
		$plugin_data = EasyPoll::plugin_data();
		$post_type   = get_post_type();
		$page        = $_GET['page'] ?? ''; //phpcs:ignore

		// load styles & scripts only required page.
		if ( 'easy-poll' === $post_type || 'ep-settings' === $page || 'ep-report' === $page ) {
			wp_enqueue_style( 'ep-backend-style', $plugin_data['assets'] . 'bundles/backend-style.min.css', array(), filemtime( $plugin_data['plugin_path'] . 'assets/bundles/backend-style.min.css' ) );

			wp_enqueue_script( 'ep-backend-script', $plugin_data['assets'] . 'bundles/backend.min.js', array( 'wp-i18n' ), filemtime( $plugin_data['plugin_path'] . 'assets/bundles/backend.min.js' ), true );

			// add data to use in js files.
			wp_add_inline_script( 'ep-backend-script', 'const epData = ' . json_encode( self::scripts_data() ), 'before' );
		}
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
}

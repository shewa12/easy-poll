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
		// frontend scripts.
		// add_action( 'wp_enqueue_scripts', array( __CLASS__, 'load_front_end_scripts' ) );

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'script_text_domain' ) );
	}

	/**
	 * Load admin styles & scripts
	 *
	 * @return void
	 */
	public static function load_admin_scripts(): void {
		$plugin_data = EasyPoll::plugin_data();
		$post_type   = get_post_type();

		// load styles & scripts only required page.
		if ( 'easy-poll' === $post_type ) {
			wp_enqueue_style( 'ep-backend-style', $plugin_data['assets'] . 'bundles/backend-style.min.css', array(), filemtime( $plugin_data['plugin_path'] . 'assets/bundles/backend-style.min.css' ) );

			wp_enqueue_script( 'ep-backend-script', $plugin_data['assets'] . 'bundles/backend.min.js', array( 'wp-i18n' ), filemtime( $plugin_data['plugin_path'] . 'assets/bundles/backend.min.js' ), true );

			// add data to use in js files.
			wp_add_inline_script( 'ep-backend-script', 'const epData = ' . json_encode( self::scripts_data() ), 'before' );
		}

	}

	/**
	 * Add inline data in scripts
	 *
	 * @return array
	 */
	public static function scripts_data() {
		$plugin_data = EasyPoll::plugin_data();
		$data        = array(
			'url'          => admin_url( 'admin-ajax.php' ),
			'nonce'        => wp_create_nonce( $plugin_data['nonce'] ),
			'nonce_action' => $plugin_data['nonce_action'],
		);
		return apply_filters( 'ep_inline_script_data', $data );
	}

	/**
	 * Script text domain
	 *
	 * @return void
	 */
	public static function script_text_domain() {
		$plugin_data = EasyPoll::plugin_data();

		wp_set_script_translations( 'ep-backend-scripts', 'ep-frontend-scripts', $plugin_data['plugin_path'] . 'languages/' );
	}
}

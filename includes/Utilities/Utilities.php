<?php
/**
 * Contains utilities static methods
 *
 * @since    v1.0.0
 *
 * @package  EasyPoll\Utilities
 */

namespace EasyPoll\Utilities;

use EasyPoll;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Plugin's utilities
 */
class Utilities {

	/**
	 * Load template file
	 *
	 * @param string $template  required template file relative path.
	 * @param mixed  $data  data that will be available on the file.
	 * @param bool   $once  if true file will be included once.
	 *
	 * @return void
	 */
	public static function load_template( string $template, $data = '', $once = false ) {
		$plugin_data = EasyPoll::plugin_data();
		$template    = trailingslashit( $plugin_data['templates'] ) . $template;
		if ( file_exists( $template ) ) {
			if ( $once ) {
				include_once $template;
			} else {
				include $template;
			}
		} else {
			echo esc_html( $template . ' file not found' );
		}
	}

	/**
	 * Load template file
	 *
	 * @param string $template  required views relative path,
	 * path should be before views folder.
	 * @param mixed  $data  data that will be available on the file.
	 * @param bool   $once  if true file will be included once.
	 *
	 * @return void
	 */
	public static function load_views( string $template, $data = '', $once = false ) {
		$plugin_data = EasyPoll::plugin_data();
		$template    = trailingslashit( $plugin_data['views'] ) . $template;
		if ( file_exists( $template ) ) {
			if ( $once ) {
				include_once $template;
			} else {
				include $template;
			}
		} else {
			echo esc_html( $template . ' file not found' );
		}
	}
	/**
	 * Load custom file from any path provided
	 *
	 * @param string $template  provide full path of a file.
	 * @param mixed  $data  data that will be available on the file.
	 * @param bool   $once  if true file will be included once.
	 *
	 * @return void
	 */
	public static function load_file_from_custom_path( string $template, $data = '', $once = false ) {
		if ( file_exists( $template ) ) {
			if ( $once ) {
				include_once $template;
			} else {
				include $template;
			}
		} else {
			echo esc_html( $template . ' file not found' );
		}
	}

	/**
	 * Create nonce field.
	 *
	 * @since v1.0.0
	 *
	 * @return void
	 */
	public static function create_nonce_field() {
		$plugin_data = EasyPoll::plugin_data();
		wp_nonce_field( $plugin_data['nonce_action'], $plugin_data['nonce'] );
	}

	/**
	 * Verify nonce not it verified then die
	 *
	 * @since v1.0.0
	 *
	 * @return void
	 */
	public static function verify_nonce() {
		$plugin_data = EasyPoll::plugin_data();
		if ( isset( $_POST[ $plugin_data['nonce'] ] ) && ! wp_verify_nonce( $_POST[ $plugin_data['nonce'] ], $plugin_data['nonce_action'] ) ) {
			die( __( 'Tutor periscope nonce verification failed', 'tutor-periscope' ) );
		}
	}

	/**
	 * Sanitize fields
	 *
	 * @since v1.0.0
	 *
	 * @param mixed $data string or array data to sanitize.
	 *
	 * @return mixed return input data after sanitize
	 */
	public static function sanitize( $data ) {
		if ( is_array( $data ) ) {
			$data = array_map(
				function( $value ) {
					return sanitize_text_field( $value );
				},
				$data
			);
		} else {
			$data = sanitize_text_field( $data );
		}
		return $data;
	}
}

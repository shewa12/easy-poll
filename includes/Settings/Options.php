<?php
/**
 * Poll settings
 *
 * @since v1.0.0
 *
 * @package EasyPoll\Settings
 */

namespace EasyPoll\Settings;

use EasyPoll\Utilities\Utilities;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Customization options
 */
class Options {

	/**
	 * Option key name
	 *
	 * @var OPTION_KEY
	 */
	const OPTION_KEY = 'ep-settings';

	/**
	 * Register hooks
	 *
	 * @since v1.0.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_ep_settings_update', __CLASS__ . '::settings_update' );
	}

	/**
	 * Get poll settings
	 *
	 * @since v1.0.0
	 *
	 * @return array  array of settings
	 */
	public static function get_settings_options() {
		return apply_filters(
			'easy-poll-options',
			array(
				array(
					'label'       => __( 'Container Width' ),
					'field_type'  => 'radio',
					'option_name' => 'ep-container-width',
					'options'     => array(
						array(
							'value' => 'yes',
							'label' => __( 'Yes', 'easy-poll' ),
						),
						array(
							'value' => 'no',
							'label' => __( 'No', 'easy-poll' ),
						),
					),
					'description' => __( 'Adjust the front-end poll template width', 'easy-poll' ),
					'default'     => 'yes',
				),
				array(
					'label'       => __( 'Max Width', 'easy-poll' ),
					'field_type'  => 'number',
					'option_name' => 'ep-max-width',
					'description' => __( 'Set max-width in percentage for the large screen devices', 'easy-poll' ),
					'default'     => 60,
				),
				array(
					'label'       => __( 'Thumbnail Size', 'easy-poll' ),
					'field_type'  => 'dropdown',
					'option_name' => 'ep-thumbnail-size',
					'options'     => array(
						array(
							'value' => 'thumbnail',
							'label' => __( 'Thumbnail', 'easy-poll' ),
						),
						array(
							'value' => 'medium',
							'label' => __( 'Medium', 'easy-poll' ),
						),
						array(
							'value' => 'medium_large',
							'label' => __( 'Medium Large', 'easy-poll' ),
						),
						array(
							'value' => 'large',
							'label' => __( 'Large', 'easy-poll' ),
						),
						array(
							'value' => 'full',
							'label' => __( 'Full', 'easy-poll' ),
						),
					),
					'description' => __( 'Poll thumbnail size', 'easy-poll' ),
					'default'     => 'medium',
				),
				array(
					'label'       => __( 'Select Multiple Hint', 'easy-poll' ),
					'field_type'  => 'input',
					'option_name' => 'ep-select-multiple-text',
					'description' => __( 'Show a message so that users can understand that they can select multiple', 'easy-poll' ),
					'default'     => __( 'Select multiple if required', 'easy-poll' ),
				),
				array(
					'label'       => __( 'Success Message', 'easy-poll' ),
					'field_type'  => 'textarea',
					'option_name' => 'ep-success-message',
					'description' => __( 'Show a message after successful poll submission', 'easy-poll' ),
					'default'     => __( 'Thank you for submitting poll', 'easy-poll' ),
				),
				array(
					'label'       => __( 'Guest Submit', 'easy-poll' ),
					'field_type'  => 'radio',
					'option_name' => 'ep-allow-guest',
					'options'     => array(
						array(
							'value' => 'yes',
							'label' => __( 'Yes', 'easy-poll' ),
						),
						array(
							'value' => 'no',
							'label' => __( 'No', 'easy-poll' ),
						),
					),
					'description' => __( 'If allowed, any (logged-in/guest) users will be able to see & submit the poll.', 'easy-poll' ),
					'default'     => __( 'no', 'easy-poll' ),
				),
			),
		);
	}

	/**
	 * Save default settings, it will be used for one time
	 * on the plugin activation.
	 *
	 * @since v1.0.0
	 *
	 * @return void
	 */
	public static function save_default_settings() {
		$options       = self::get_settings_options();
		$option_names  = array_column( $options, 'option_name' );
		$option_values = array_column( $options, 'default' );

		$combined_options = array_combine( $option_names, $option_values );

		do_action( 'easy_poll_before_default_settings_save', $combined_options );
		update_option( self::OPTION_KEY, $combined_options );
		do_action( 'easy_poll_after_default_settings_save', $combined_options );
	}

	/**
	 * Update settings
	 *
	 * @since v1.0.0
	 *
	 * @return void  send wp json response
	 */
	public static function settings_update(): void {
		Utilities::verify_nonce();
		$post = Utilities::sanitize( $_POST ); //phpcs:ignore
		update_option( self::OPTION_KEY, $post );
		wp_send_json_success();
	}

	/**
	 * Get option by key
	 *
	 * @since v1.0.0
	 *
	 * @param string $key  option key.
	 *
	 * @return mixed option value on success or false if
	 * option not found
	 */
	public static function get_option( string $key ) {
		$options = get_option( self::OPTION_KEY, false );
		$value   = false;
		if ( $options && isset( $options[ $key ] ) ) {
			$value = $options[ $key ];
		}
		return $value;
	}
}

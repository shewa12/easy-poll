<?php
/**
 * Form client class is for interacting with form builder
 *
 * @since v1.0.0
 * @package TutorPeriscope\FormBuilder
 */

namespace EasyPoll\FormBuilder;

use EasyPoll;
use EasyPoll\Database\EasyPollFeedback;
use EasyPoll\Database\EasyPollFields;
use EasyPoll\Database\EasyPollOptions;
use EasyPoll\Utilities\Utilities;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Interact with form builder, form field builder
 */
class FormClient {

	protected $form_builder;
	protected $form_field_builder;
	protected $field_options;

	protected $poll_table;
	protected $field_table;
	protected $field_option_table;
	protected $feedback_table;

	/**
	 * Init props & register hooks
	 *
	 * @since v1.0.0
	 */
	public function __construct() {
		global $wpdb;
		// Initialize props.
		$this->form_builder       = FormBuilder::create( 'Form' );
		$this->form_field_builder = FormBuilder::create( 'FormField' );
		$this->field_options      = FormBuilder::create( 'FieldOptions' );

		// Initialize table props.
		$this->poll_table         = $wpdb->posts;
		$this->field_table        = $wpdb->prefix . EasyPollFields::get_table();
		$this->field_option_table = $wpdb->prefix . EasyPollOptions::get_table();
		$this->feedback_table     = $wpdb->prefix . EasyPollFeedback::get_table();

		// Register hooks.
		add_action( 'wp_ajax_ep_single_multiple_question_create', array( $this, 'single_multiple_question_create' ) );

		add_action( 'wp_ajax_ep_input_textarea_question_create', array( $this, 'input_textarea_question_create' ) );
	}

	/**
	 * Handle ajax request, create single/multiple choice question
	 *
	 * @since v1.0.0
	 *
	 * @return wp_json response
	 */
	public function single_multiple_question_create() {
		Utilities::verify_nonce();

		$post    = $_POST; //phpcs:ignore WordPress.Security.NonceVerification.Missing
		$request = array(
			'poll_id'     => $post['poll-id'],
			'field_label' => $post['ep-field-label'],
			'field_type'  => $post['ep-field-type'],
		);

		$response      = false;
		$error_message = __( 'Field creation failed!', 'easy-poll' );
		// Get field id that is inserted.
		$field_id = $this->form_field_builder->create( $request );
		if ( $field_id ) {
			$options = array();
			// Prepare options.
			foreach ( $post['ep-field-option'] as $option ) {
				if ( '' === $option ) {
					continue;
				}
				$data = array(
					'field_id'     => $field_id,
					'option_label' => $option,
				);
				array_push( $options, $data );
			}
			// Insert field options.
			if ( count( $options ) ) {
				$response = $this->field_options->create_multiple( $options );
				if ( ! $response ) {
					$error_message = __( 'Field options creation failed!', 'easy-poll' );
				}
			}
		}
		return $response ? wp_send_json_success( $response ) : wp_send_json_error( $error_message );
	}

	/**
	 * Handle ajax request, create input/textarea question
	 *
	 * @since v1.0.0
	 *
	 * @return wp_json response
	 */
	public function input_textarea_question_create() {
		Utilities::verify_nonce();

		$post    = $_POST; //phpcs:ignore WordPress.Security.NonceVerification.Missing
		$request = array();

		foreach ( $post['ep-field-label'] as $key => $field ) {
			if ( '' === $field ) {
				continue;
			}

			$data = array(
				'poll_id'     => $post['poll-id'],
				'field_label' => $field,
				'field_type'  => $post['ep-field-type'][ $key ],
			);
			array_push( $request, $data );
		}

		if ( count( $request ) ) {
			$response = $this->form_field_builder->create_multiple( $request );
			return $response ? wp_send_json_success( $response ) : wp_send_json_error( __( 'Field creation failed!', 'easy-poll' ) );
		} else {
			return wp_send_json_error( __( 'Field not exist!', 'easy-poll' ) );
		}
	}

	/**
	 * Get fields data along with options & feedback id.
	 *
	 * It useful for poll fields listing. Feedback id is a indicator
	 * here, to understand whether this field has data or not.
	 *
	 * @since v1.0.0
	 *
	 * @param int $poll_id  poll id, thats field will be fetched.
	 *
	 * @return array wpdb::result response
	 */
	public function get_poll_fields_with_option( int $poll_id ): array {
		global $wpdb;
		// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT
					field.*,
					field_option.*,
					feedback.id
					FROM {$this->field_table} AS field

					LEFT JOIN {$this->field_option_table} AS field_option
						ON field_option.field_id = field.id

					LEFT JOIN {$this->feedback_table} AS feedback
						ON feedback.field_id = field.id

					WHERE field.poll_id = %d
				",
				$poll_id
			)
		);
		return is_array( $results ) && count( $results ) ? $results : array();
	}

}

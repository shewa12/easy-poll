<?php
/**
 * Form client class is for interacting with form builder
 *
 * @since v1.0.0
 * @package TutorPeriscope\FormBuilder
 */

namespace EasyPoll\FormBuilder;

use EasyPoll\Database\EasyPollFeedback;
use EasyPoll\Database\EasyPollFields;
use EasyPoll\Database\EasyPollOptions;
use EasyPoll\Helpers\QueryHelper;
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

	/**
	 * Init props & register hooks
	 *
	 * @since v1.0.0
	 */
	public function __construct( $init_hook = true ) {

		// Initialize props.
		$this->form_builder       = FormBuilder::create( 'Form' );
		$this->form_field_builder = FormBuilder::create( 'FormField' );
		$this->field_options      = FormBuilder::create( 'FieldOptions' );

		/**
		 * In Some cases, we may need to call method without
		 * register hooks.
		 */
		if ( true !== $init_hook ) {
			return;
		}
		// Register hooks.
		add_action( 'wp_ajax_ep_single_multiple_question_create', array( $this, 'single_multiple_question_create' ) );

		add_action( 'wp_ajax_ep_input_textarea_question_create', array( $this, 'input_textarea_question_create' ) );

		add_action( 'wp_ajax_ep_field_delete', array( $this, 'field_delete' ) );
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

		$options = array();
		// Prepare options.
		foreach ( $post['ep-field-option'] as $option ) {
			if ( '' === $option ) {
				continue;
			}
			$data = array(
				'field_id'     => '',
				'option_label' => $option,
			);
			array_push( $options, $data );
		}

		if ( count( $options ) > 1 ) {
			// Get field id that is inserted.
			$field_id = $this->form_field_builder->create( $request );

			// Map field id to options.
			$map_options = array();

			foreach ( $options as $option ) {
				$option['field_id'] = $field_id;
				array_push( $map_options, $option );
			}

			if ( $field_id ) {
				// Insert field options.
				$response = $this->field_options->create_multiple( $map_options );
				if ( ! $response ) {
					$error_message = __( 'Field options creation failed!', 'easy-poll' );
				}
			}
		} else {
			$error_message = __( 'Add two or more options', 'easy-poll' );
		}

		// Field & options that is inserted in DB.
		$request['field_id'] = $field_id;
		$response_data       = array(
			'field'   => $request,
			'options' => $options,
		);

		return $response ? wp_send_json_success( $response_data ) : wp_send_json_error( $error_message );
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

		$post     = $_POST; //phpcs:ignore WordPress.Security.NonceVerification.Missing
		$request  = array();
		$response = false;
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
		if ( count( $request ) > 1 ) {
			$response = $this->form_field_builder->create_multiple( $request );
		} elseif ( count( $request ) && isset( $request[0] ) ) {
			$response = $this->form_field_builder->create( $request[0] );
		}
		return $response ? wp_send_json_success( $request ) : wp_send_json_error( __( 'Field creation failed!', 'easy-poll' ) );
	}

	/**
	 * Delete form question
	 *
	 * @since v1.0.0
	 *
	 * @return void  send wp_json response
	 */
	public function field_delete() {
		Utilities::verify_nonce();
		$field_id    = $_POST['field_id'] ?? '';
		$field_label = $_POST['field_label'] ?? '';

		/**
		 * For dynamically added field, field id is not set. In this case
		 * need to fetch field id by using field label.
		 */
		if ( '' === $field_id ) {
			if ( '' !== $field_label ) {
				$field = QueryHelper::get_one(
					$this->form_field_builder->get_table(),
					array( 'field_label' => $field_label )
				);
				if ( $field ) {
					$field_id = $field->id;
				}
			}
		}
		if ( $field_id ) {
			// @ep-action-hook.
			do_action( 'easy_poll_before_delete_question', $field_id );
			$delete = $this->form_field_builder->delete( wp_unslash( $field_id ) ); //phpcs:ignore
			$delete ? wp_send_json_success() : wp_send_json_error( __( 'Delete failed! Please try again.', 'easy-poll' ) );
		} else {
			wp_send_json_error( __( 'Invalid question id! Please refresh the page.', 'easy-poll' ) );
		}
	}

}

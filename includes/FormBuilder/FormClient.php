<?php
/**
 * Form client class is for interacting with form builder
 *
 * @since v1.0.0
 * @package TutorPeriscope\FormBuilder
 */

namespace EasyPoll\FormBuilder;

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

	/**
	 * Init props & register hooks
	 *
	 * @since v1.0.0
	 */
	public function __construct() {
		// Initialize props.
		$this->form_builder       = FormBuilder::create( 'Form' );
		$this->form_field_builder = FormBuilder::create( 'FormField' );

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

		$post     = $_POST; //phpcs:ignore WordPress.Security.NonceVerification.Missing
		$request  = array(
			'poll_id'     => $post['poll-id'],
			'field_label' => $post['ep-field-label'],
			'field_type'  => $post['ep-field-type'],
		);
		$response = $this->form_field_builder->create( $request );
		return $response ? wp_send_json_success( $response ) : wp_send_json_error( __( 'Field creation failed!', 'easy-poll' ) );
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

		$post = $_POST; //phpcs:ignore WordPress.Security.NonceVerification.Missing
		$request = array();

		foreach ( $post['ep-field-label'] as $key => $field ) {
			if ( '' === $field ) {
				continue;
			}

			$data = array(
				'poll_id'         => $post['poll-id'],
				'field_label'     => $field,
				'field_type'      => $post['ep-field-type'][ $key ],
			);
			array_push( $request, $data );
		}

		if ( count( $request ) ) {
			$response = $this->form_field_builder->create_multiple( $request );
			return $response ? wp_send_json_success( $response ) : wp_send_json_error( __( 'Field creation failed!', 'easy-poll' ) );
		} else {
			return wp_send_json_error( __( 'Field not exist!', 'easy-poll') );
		}
	}

}

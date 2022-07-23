<?php
/**
 * Form client class is for interacting with form builder
 *
 * @since v1.0.0
 * @package TutorPeriscope\FormBuilder
 */

namespace EasyPoll\FormBuilder;

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

		add_action( 'wp_ajax_ep_single_multiple_question_create', __CLASS__ . '::single_multiple_question_create' );

		add_action( 'wp_ajax_ep_input_textarea_question_create', __CLASS__ . '::input_textarea_question_create' );
	}

	/**
	 * Handle ajax request, create single/multiple choice question
	 *
	 * @since v1.0.0
	 *
	 * @return void wp_json response
	 */
	public static function single_multiple_question_create() {
		wp_send_json_success( $_POST );
	}

	/**
	 * Handle ajax request, create input/textarea question
	 *
	 * @since v1.0.0
	 *
	 * @return void wp_json response
	 */
	public static function input_textarea_question_create() {
		wp_send_json_success( $_POST );
	}

}

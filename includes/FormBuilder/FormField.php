<?php
/**
 * Form field concrete class
 *
 * @since v1.0.0
 * @package EasyPoll\FormBuilder
 */

namespace EasyPoll\FormBuilder;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use EasyPoll;
use EasyPoll\FormBuilder\FormInterface;
use EasyPoll\Utilities\Utilities;

class FormField implements FormInterface {

	public function create( array $request ) {

	}

	public function get_one( int $id ): object {

	}

	public function get_list(): array {

	}

	public function update( array $request, int $id ): bool {

	}

	public function delete( int $id ): bool {

	}

	/**
	 * Get available field type for creating poll
	 *
	 * @since v1.0.0
	 *
	 * @param string $selected  value for the selected field.
	 *
	 * @return array  field types
	 */
	public static function field_types( string $selected = '' ): array {
		$field_types = array(
			array(
				'label'    => __( 'Select Field Type', 'easy-poll' ),
				'value'    => '',
				'selected' => '' === $selected ? true : false,
			),
			array(
				'label'    => __( 'Single Choice', 'easy-poll' ),
				'value'    => 'single_choice',
				'selected' => 'single_choice' === $selected ? true : false,
			),
			array(
				'label'    => __( 'Multiple Choice', 'easy-poll' ),
				'value'    => 'multiple_choice',
				'selected' => 'multiple_choice' === $selected ? true : false,
			),
			array(
				'label'    => __( 'Input Field', 'easy-poll' ),
				'value'    => 'input',
				'selected' => 'input' === $selected ? true : false,
			),
			array(
				'label'    => __( 'Textarea', 'easy-poll' ),
				'value'    => 'textarea',
				'selected' => 'textarea' === $selected ? true : false,
			),
		);
		return apply_filters(
			'ep_field_types',
			$field_types
		);
	}

	/**
	 * Load single/multiple choice modal
	 *
	 * It will include modal where the method is called, once the
	 * opener modal button trigger it would be visible.
	 *
	 * @since v1.0.0
	 *
	 * @param string $modal_id  unique modal id.
	 *
	 * @return void
	 */
	public static function load_single_multiple_choice_modal( string $modal_id ): void {
		// Load modal.
		$plugin_data            = EasyPoll::plugin_data();
		$single_multiple_choice = array(
			'modal_id'       => $modal_id,
			'header_title'   => __( 'Add Question', 'easy-poll' ),
			'body_content'   => $plugin_data['views'] . '/metabox/single-multiple-choice-fields.php',
			'footer_buttons' => array(
				array(
					'text'  => __( 'Save', 'easy-poll' ),
					'id'    => '',
					'class' => 'ep-btn ep-btn-secondary',
					'type'  => 'submit',
				),
				array(
					'text'  => __( 'Save & Close', 'easy-poll' ),
					'id'    => '',
					'class' => 'ep-btn',
					'type'  => 'submit',
				),
			),
			'ajax_action'    => 'ep_single_multiple_question_create',
		);
		Utilities::load_template( 'components/modal.php', $single_multiple_choice );
	}

	/**
	 * Load input/textarea modal
	 *
	 * It will include modal where the method is called, once the
	 * opener modal button trigger it would be visible.
	 *
	 * @since v1.0.0
	 *
	 * @param string $modal_id  unique modal id.
	 *
	 * @return void
	 */
	public static function load_input_textarea_modal( string $modal_id ): void {
		// Load modal.
		$plugin_data            = EasyPoll::plugin_data();
		$input_textarea = array(
			'modal_id'       => $modal_id,
			'header_title'   => __( 'Add Question', 'easy-poll' ),
			'body_content'   => $plugin_data['views'] . '/metabox/input-textarea-fields.php',
			'footer_buttons' => array(
				array(
					'text'  => __( 'Save Questions', 'easy-poll' ),
					'id'    => '',
					'class' => 'ep-btn',
					'type'  => 'submit',
				),
			),
			'ajax_action' => 'ep_input_textarea_question_create',
		);
		Utilities::load_template( 'components/modal.php', $input_textarea );
	}
}

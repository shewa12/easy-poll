<?php
/**
 * Form field concrete class
 *
 * @since v1.0.0
 * @package TutorPeriscope\FormBuilder
 */

namespace EasyPoll\FormBuilder;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use EasyPoll\FormBuilder\FormInterface;

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
				'label'    => __( 'Double Choice', 'easy-poll' ),
				'value'    => 'double_choice',
				'selected' => 'double_choice' === $selected ? true : false,
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
}

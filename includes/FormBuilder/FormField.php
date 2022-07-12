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

use EasyPoll\FormInterface;

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
	 * @return array  field types
	 */
	public static function field_types(): array {
		return apply_filters(
			'ep_field_types',
			array(
				array(
					'single_choice' => __( 'Single Choice', 'easy-poll' ),
				),
				array(
					'double_choice' => __( 'Double Choice', 'easy-poll' ),
				),
				array(
					'input_field' => __( 'Input Field', 'easy-poll' ),
				),
				array(
					'textarea' => __( 'Textarea', 'easy-poll' ),
				),
			)
		);
	}
}

<?php
/**
 * Form concrete class
 *
 * @since v1.0.0
 * @package EasyPoll\FormBuilder
 */

namespace EasyPoll\FormBuilder;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use EasyPoll\FormBuilder\FormInterface;

class Form implements FormInterface {

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
}

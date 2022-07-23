<?php
/**
 * Field options concrete class
 *
 * @since v1.0.0
 * @package EasyPoll\FormBuilder
 */

namespace EasyPoll\FormBuilder;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use EasyPoll\Database\EasyPollOptions;
use EasyPoll\FormBuilder\FormInterface;
use EasyPoll\Helpers\QueryHelper;

/**
 * Manage form fields
 */
class FieldOptions implements FormInterface {

	/**
	 * Get table name
	 *
	 * @since v1.0.0
	 *
	 * @return string
	 */
	public function get_table() {
		global $wpdb;
		return $wpdb->prefix . EasyPollOptions::get_table();
	}

	/**
	 * Create field
	 *
	 * @param array $request  request to insert data.
	 *
	 * @return int   inserted row id
	 */
	public function create( array $request ) {
		return QueryHelper::insert( $this->get_table(), $request );
	}

	/**
	 * Create multiple field together
	 *
	 * @param array $request  request to insert data two
	 * dimensional data.
	 *
	 * @return mixed  wpdb response true or int on success, false on failure
	 */
	public function create_multiple( array $request ) {
		return QueryHelper::insert_multiple_rows( $this->get_table(), $request );
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

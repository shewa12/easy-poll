<?php
/**
 * Form interface
 *
 * @since v1.0.0
 * @package EasyPoll\FormBuilder
 */

namespace EasyPoll\FormBuilder;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface FormInterface {

	/**
	 * Create single row
	 *
	 * @param array $request  form data.
	 *
	 * @since v1.0.0
	 */
	public function create( array $request );

	/**
	 * Get one row
	 *
	 * @since v1.0.0
	 *
	 * @param int $id  id column.
	 */
	public function get_one( int $id ): object;

	/**
	 * Get all list
	 *
	 * @since v1.0.0
	 */
	public function get_list(): array;

	/**
	 * Update a row
	 *
	 * @since v1.0.0
	 *
	 * @param array $request  form data to update, key value pair.
	 * @param int   $id  column id that will be updated.
	 */
	public function update( array $request, int $id): bool;

	/**
	 * Delete a row
	 *
	 * @since v1.0.0
	 *
	 * @param int $id  column id that need to be deleted.
	 */
	public function delete( int $id ): bool;
}

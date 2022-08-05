<?php
/**
 * Manage poll feedback
 *
 * @since v1.0.0
 *
 * @package EasyPoll\FormBuilder
 */

namespace EasyPoll\FormBuilder;

use EasyPoll\Database\EasyPollFeedback;
use EasyPoll\Helpers\QueryHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle feedback
 */
class Feedback {

	/**
	 * Get table name
	 *
	 * @return string table name
	 */
	public static function get_table() {
		global $wpdb;
		return $wpdb->prefix . EasyPollFeedback::get_table();
	}

	/**
	 * Save all feedback
	 *
	 * @since v1.0.0
	 *
	 * @param array $request  array of data to insert.
	 *
	 * @return bool  true on success false on failure
	 */
	public static function save_feedback( array $request ): bool {
		$table    = self::get_table();
		$response = false;
		if ( count( $request ) ) {
			if ( count( $request ) > 1 ) {
				$response = QueryHelper::insert_multiple_rows( $table, $request );
			} else {
				$response = QueryHelper::insert( $table, $request );
			}
		}

		return $response ? true : false;
	}
}

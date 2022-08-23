<?php
/**
 * Manage poll feedback
 *
 * @since v1.0.0
 *
 * @package EasyPoll\FormBuilder
 */

namespace EasyPoll\FormBuilder;

use EasyPoll\CustomPosts\EasyPollPost;
use EasyPoll\Database\EasyPollFeedback;
use EasyPoll\Database\EasyPollFields;
use EasyPoll\Helpers\QueryHelper;
use EasyPoll\Utilities\Utilities;

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
				$response = QueryHelper::insert( $table, $request[0] );
			}
		}

		return $response ? true : false;
	}

	/**
	 * Check whether current user already submitted poll or not
	 *
	 * @since v1.0.0
	 *
	 * @param int $poll_id  poll id to check.
	 *
	 * @return bool
	 */
	public static function is_user_already_submitted( $poll_id ): bool {
		global $wpdb;

		$poll_table     = $wpdb->posts;
		$field_table    = $wpdb->prefix . EasyPollFields::get_table();
		$feedback_table = $wpdb->prefix . EasyPollFeedback::get_table();

		$poll_id   = Utilities::sanitize( $poll_id );
		$user_id   = get_current_user_id();
		$user_ip   = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
		$submitted = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT
						feedback.id
					FROM {$feedback_table} AS feedback

					INNER JOIN {$field_table} AS field
						ON field.id = feedback.field_id

					INNER JOIN {$poll_table} AS poll
						ON poll.ID = field.poll_id
						AND poll.post_type = %s
						
					WHERE poll.ID = %d 
						AND feedback.user_id = %d
						
					",
				EasyPollPost::post_type(),
				$poll_id,
				$user_id
			)
		);
		return (bool) $submitted;
	}

	/**
	 * Get total feedback of a poll
	 *
	 * @since v1.0.0
	 *
	 * @param int $poll_id  poll id to check.
	 *
	 * @return int  total submitted feedback
	 */
	public static function total_submission( int $poll_id ): int {
		global $wpdb;

		$poll_table     = $wpdb->posts;
		$field_table    = $wpdb->prefix . EasyPollFields::get_table();
		$feedback_table = $wpdb->prefix . EasyPollFeedback::get_table();

		$poll_id   = Utilities::sanitize( $poll_id );

		$total = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT 
					IFNULL(COUNT(DISTINCT feedback.user_id), COUNT(DISTINCT feedback.user_ip))
				 	AS total

				FROM {$feedback_table} AS feedback

				INNER JOIN {$field_table} AS field
					ON field.id = feedback.field_id
					
				INNER JOIN {$poll_table} AS poll
					ON poll.ID = field.poll_id
					AND poll.post_type = %s

				WHERE poll.ID = %d
				",
				EasyPollPost::post_type(),
				$poll_id
			)
		);
		return (int) $total;
	}
}

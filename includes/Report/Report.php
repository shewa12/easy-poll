<?php
/**
 * Manage poll reports
 *
 * @since v1.0.0
 *
 * @package EasyPoll\Reports
 */

namespace EasyPoll\Report;

use EasyPoll\Database\EasyPollFeedback;
use EasyPoll\Database\EasyPollFields;
use EasyPoll\Database\EasyPollOptions;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Poll Report
 */
class Report {

	/**
	 * Set poll table name
	 *
	 * @var $poll_table
	 */
	protected $poll_table;

	/**
	 * Set poll table name
	 *
	 * @var $field_table
	 */
	protected $field_table;

	/**
	 * Set poll table name
	 *
	 * @var $option_table
	 */
	protected $option_table;

	/**
	 * Set poll table name
	 *
	 * @var $feedback_table
	 */
	protected $feedback_table;

	/**
	 * Define props
	 *
	 * @since v1.0.0
	 */
	public function __construct() {
		global $wpdb;
		$this->poll_table     = $wpdb->posts;
		$this->field_table    = $wpdb->prefix . EasyPollFields::get_table();
		$this->option_table   = $wpdb->prefix . EasyPollOptions::get_table();
		$this->feedback_table = $wpdb->prefix . EasyPollFeedback::get_table();
	}

	/**
	 * Get report type
	 *
	 * @return array
	 */
	public static function get_report_types(): array {
		return array(
			'summary' => __( 'Summary', 'easy-poll' ),
			'list'    => __( 'List', 'easy-poll' ),
		);
	}

	/**
	 * Get submission list by poll id
	 *
	 * @param int $poll_id  poll id required.
	 * @param int $limit  limit of paging default 10.
	 * @param int $offset  offset for paging default 0.
	 *
	 * @return array  wpdb::get_results
	 */
	public function get_submission_list( int $poll_id, int $limit = 10, int $offset = 0 ): array {
		global $wpdb;
        // @codingStandardsIgnoreStart
		$results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT
                    poll.ID,
                    poll.post_title,
                    GROUP_CONCAT(field.field_label SEPARATOR '__') AS questions,
                    GROUP_CONCAT(field.id SEPARATOR '__') AS question_ids,
                    GROUP_CONCAT(field.field_type SEPARATOR '__') AS question_types,
                    GROUP_CONCAT(pfeedback.feedback SEPARATOR '__') AS user_feedback,
                    pfeedback.user_id,
                    pfeedback.user_ip
                    
                FROM {$this->poll_table} AS poll
                
                INNER JOIN {$this->field_table} AS field
                    ON field.poll_id = poll.ID
                    
                INNER JOIN {$this->feedback_table} AS pfeedback
                    ON pfeedback.field_id = field.id
                    
                WHERE poll.ID = %d
                GROUP BY pfeedback.user_id, pfeedback.user_ip

				LIMIT %d OFFSET %d
                ",
				$poll_id,
				$limit,
				$offset
			)
		);
		
        // @codingStandardsIgnore
		return $results ? $results : array();
	}

	/**
	 * Get total number of submission
	 *
	 * @param int $poll_id  poll id required.
	 *
	 * @return int total counted number
	 */	
	public function count_submissions( int $poll_id ): int {
		global $wpdb;
        // @codingStandardsIgnoreStart
		$total_count = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT
                    poll.ID,
                    poll.post_title,
                    GROUP_CONCAT(field.field_label SEPARATOR '__') AS questions,
                    GROUP_CONCAT(field.id SEPARATOR '__') AS question_ids,
                    GROUP_CONCAT(field.field_type SEPARATOR '__') AS question_types,
                    GROUP_CONCAT(pfeedback.feedback SEPARATOR '__') AS user_feedback,
                    pfeedback.user_id,
                    pfeedback.user_ip
            
                FROM {$this->poll_table} AS poll
                
                INNER JOIN {$this->field_table} AS field
                    ON field.poll_id = poll.ID
                    
                INNER JOIN {$this->feedback_table} AS pfeedback
                    ON pfeedback.field_id = field.id
                    
                WHERE poll.ID = %d
                GROUP BY pfeedback.user_id, pfeedback.user_ip
                ",
				$poll_id
			)
		);
		// @codingStandardsIgnoreEnd
		return (int) count( $total_count );
	}
}

<?php
/**
 * Manage poll reports
 *
 * @since v1.0.0
 *
 * @package EasyPoll\Reports
 */

namespace EasyPoll\Report;

use EasyPoll\CustomPosts\EasyPollPost;
use EasyPoll\CustomPosts\PostCallBack;
use EasyPoll\Database\EasyPollFeedback;
use EasyPoll\Database\EasyPollFields;
use EasyPoll\Database\EasyPollOptions;
use EasyPoll\FormBuilder\Feedback;
use EasyPoll\Helpers\QueryHelper;
use EasyPoll\PollHandler\PollHandler;
use EasyPoll\Utilities\Utilities;
use WP_Query;

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

		add_action( 'wp_ajax_ep_get_active_polls_report', __CLASS__ . '::get_active_polls_report' );
	}

	/**
	 * Get report type
	 *
	 * @return array
	 */
	public static function get_report_types(): array {
		return array(
			'poll-summary'          => __( 'Summary', 'easy-poll' ),
			'poll-submission-lists' => __( 'Submission List', 'easy-poll' ),
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

	/**
	 * Get poll statistics
	 *
	 * @since 1.2.0
	 *
	 * @param bool $lists if true then it will provide lists
	 * otherwise post counts.
	 *
	 * @return object
	 */
	public static function get_poll_statistics( bool $lists = false ): object {
		$active_poll   = 0;
		$expired_poll  = 0;
		$upcoming_poll = 0;

		$active_list   = array();
		$upcoming_list = array();
		$expired_list  = array();

		$args = array(
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'posts_per_page'         => 1000,
		);

		// If lists false then fetch only ids.
		if ( false === $lists ) {
			$args['fields'] = 'ids';
		}

		$query = QueryHelper::wp_query( $args );
		$posts = $query->get_posts();
		foreach ( $posts as $post ) {
			$datetime = PostCallBack::get_poll_datetime( is_object( $post ) ? $post->ID : $post );
			$status   = PollHandler::check_poll_status( $datetime->start_datetime, $datetime->expire_datetime );

			if ( 'poll-active' === $status ) {
				$active_poll++;
				array_push( $active_list, $post );
			} elseif ( 'poll-expired' === $status ) {
				$expired_poll++;
				array_push( $expired_list, $post );
			} else {
				$upcoming_poll++;
				array_push( $upcoming_list, $post );
			}
		}

		if ( false === $lists ) {
			$response = array(
				'active'   => $active_poll,
				'expired'  => $expired_poll,
				'upcoming' => $upcoming_poll,
			);
		} else {
			$response = array(
				'active'   => $active_list,
				'expired'  => $expired_list,
				'upcoming' => $upcoming_list,
			);
		}
		return (object) $response;
	}

	/**
	 * Get active polls report
	 *
	 * @since 1.2.0
	 *
	 * @param integer $days report days. Report will be
	 * generated as per mention days. Default is 7 days which
	 * means report between (current_date - 7 days) AND current_date.
	 *
	 * @return array
	 */
	public static function active_polls_report( int $days = 7 ): array {
		$get_polls    = self::get_poll_statistics( true );
		$active_polls = $get_polls->active;

		// Get total submission for each based on days.
		foreach ( $active_polls as $poll ) {
			$total_submission       = Feedback::total_submission( $poll->ID, 7 );
			$poll->total_submission = $total_submission;
		}
		return is_array( $active_polls ) && count( $active_polls ) ? $active_polls : array();
	}

	/**
	 * Get active polls request ajax handler
	 *
	 * @since 1.2.0
	 *
	 * @return void send wp_json response
	 */
	public static function get_active_polls_report() {
		;
		if ( false !== Utilities::verify_nonce( false ) ) {
			$active_polls = self::active_polls_report();
			wp_send_json_success( $active_polls );
		} else {
			wp_send_json_error( __( 'Nonce verification failed', 'easy-poll' ) );
		}
	}
}

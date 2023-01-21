<?php
/**
 * Manage post callback hooks such as
 * save_post, update_post, etc.
 *
 * @package EasyPoll\PostCallback
 *
 * @since 1.1.0
 */

namespace EasyPoll\CustomPosts;

use EasyPoll\ErrorHandler\ErrorHandler;
use EasyPoll\Utilities\Utilities;
use WP_Post;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Manage post hooks
 *
 * @since 1.1.0
 */
class PostCallBack {

	/**
	 * Poll start datetime key
	 *
	 * @since 1.1.0
	 *
	 * @var string
	 */
	const POLL_START_DATETIME = 'ep-poll-start-datetime';

	/**
	 * Poll end datetime key
	 *
	 * @since 1.1.0
	 *
	 * @var string
	 */
	const POLL_EXPIRE_DATETIME = 'ep-poll-end-datetime';

	/**
	 * Poll datetime zone
	 *
	 * @since 1.1.0
	 *
	 * @var string
	 */
	const POLL_DATETIME_TZ = 'ep-poll-datetime-tz';

	/**
	 * Show poll summary meta key
	 *
	 * @since 1.2.0
	 *
	 * @var string
	 */
	const SHOW_POLL_SUMMARY_KEY = 'ep-show-poll-summary';

	/**
	 * Register hooks
	 *
	 * @since 1.1.0
	 */
	public function __construct() {
		add_action( 'save_post_' . EasyPollPost::POST_TYPE, __CLASS__ . '::update_poll_start_expire_datetime' );
	}

	/**
	 * Update poll star-expire datetime after save post
	 * hook
	 *
	 * @since 1.1.0
	 *
	 * @param int $post_id post id.
	 *
	 * @return void
	 */
	public static function update_poll_start_expire_datetime( int $post_id ) {
		$start_datetime  = Utilities::sanitize_post_field( 'ep-start-datetime' );
		$expire_datetime = Utilities::sanitize_post_field( 'ep-expire-datetime' );
		$timezone        = Utilities::sanitize_post_field( 'ep-date-timezone' );

		// Return if time range is invalid.
		if ( ( '' !== $start_datetime && '' !== $expire_datetime ) && strtotime( $start_datetime ) > strtotime( $expire_datetime ) ) {
			ErrorHandler::set_errors( 'Start datetime can not be greater than expire datetime' );
			return;
		}

		update_post_meta( $post_id, self::POLL_START_DATETIME, $start_datetime );
		update_post_meta( $post_id, self::POLL_EXPIRE_DATETIME, $expire_datetime );
		update_post_meta( $post_id, self::POLL_DATETIME_TZ, $timezone );

		// Show poll summary to users after submit.
		$show = (int) isset( $_POST['ep-show-poll-summary'] );
		update_post_meta( $post_id, self::SHOW_POLL_SUMMARY_KEY, $show );
	}

	/**
	 * Get poll datetime
	 *
	 * @since 1.1.0
	 *
	 * @param int $poll_id poll post id.
	 *
	 * @return object
	 */
	public static function get_poll_datetime( int $poll_id ):object {
		// If meta value empty then set default value.
		$datetime = array(
			'start_datetime'  => get_post_meta( $poll_id, self::POLL_START_DATETIME, true ),
			'expire_datetime' => get_post_meta( $poll_id, self::POLL_EXPIRE_DATETIME, true ),
			'timezone'        => get_post_meta( $poll_id, self::POLL_DATETIME_TZ, true ),
		);
		return (object) $datetime;
	}
}

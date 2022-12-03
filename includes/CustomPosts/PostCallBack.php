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
	 * Save poll start & expire datetime & zone
	 * with this key name
	 *
	 * @since 1.1.0
	 *
	 * @var string
	 */
	const POLL_DATETIME_META_KEY = 'ep-poll-datetime';

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
		if ( '' !== $start_datetime && strtotime( $start_datetime ) > strtotime( $expire_datetime ) ) {
			ErrorHandler::set_errors( 'Start datetime can not be greater than expire datetime' );
			return;
		}

		$meta_data = array(
			'start_datetime'  => $start_datetime,
			'expire_datetime' => $expire_datetime,
			'timezone'        => $timezone,
		);

		update_post_meta(
			$post_id,
			self::POLL_DATETIME_META_KEY,
			wp_json_encode( $meta_data )
		);
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
		$datetime = json_decode( get_post_meta( $poll_id, self::POLL_DATETIME_META_KEY, true ) );
		// If meta value empty then set default value.
		if ( ! $datetime ) {
			$datetime = array(
				'start_datetime'  => '',
				'expire_datetime' => '',
				'timezone'        => '',
			);
		}
		return (object) $datetime;
	}
}

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
		$start_datetime  = sanitize_text_field( wp_unslash( $_POST['ep-start-datetime'] ) );
		$expire_datetime = sanitize_text_field( wp_unslash( $_POST['ep-expire-datetime'] ) );
		$timezone        = sanitize_text_field( wp_unslash( $_POST['ep-date-timezone'] ) );

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
}

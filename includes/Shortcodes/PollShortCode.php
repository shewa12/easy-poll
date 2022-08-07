<?php
/**
 * Poll Short Code
 *
 * @package EasyPoll\ShortCodes
 *
 * @since v1.0.0
 */

namespace EasyPoll\ShortCodes;

use EasyPoll\CustomPosts\EasyPollPost;
use EasyPoll\PollHandler\PollHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register ShortCode
 */
class PollShortCode {

	/**
	 * Namespace for API
	 */
	const SHORT_CODE_NAME = 'easy-poll';

	/**
	 * Register hooks
	 *
	 * @since v1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'init', array( __CLASS__, 'register_short_code' ) );
	}

	/**
	 * Register ShortCode
	 *
	 * @return void
	 */
	public static function register_short_code() {
		add_shortcode(
			self::SHORT_CODE_NAME,
			array( __CLASS__, 'short_code_callback' )
		);
	}

	/**
	 * Handle short code callback
	 *
	 * @since v1.0.0
	 *
	 * @param array $attrs passed attrs.
	 *
	 * @return void  short code template
	 */
	public static function short_code_callback( $attrs ) {
		$attrs   = shortcode_atts(
			array(
				'id' => null,
			),
			$attrs
		);
		$poll_id = (int) $attrs['id'] ?? 0;
		if ( get_post_type( $poll_id ) !== EasyPollPost::post_type() ) {
			return esc_html_e( 'Invalid Poll id', 'easy-poll' );
		}
		if ( $poll_id ) {
			return PollHandler::render_poll( $poll_id, false );
		} else {
			return esc_html_e( 'Invalid attribute', 'easy-poll' );
		}
	}
}

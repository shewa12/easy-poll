<?php
/**
 * Handle poll system, rendering poll on the front end
 * & handle poll submission
 *
 * @since v1.0.0
 *
 * @package EasyPoll\PollHandler
 */

namespace EasyPoll\PollHandler;

use EasyPoll;
use EasyPoll\CustomPosts\EasyPollPost;
use EasyPoll\FormBuilder\Feedback;
use EasyPoll\Utilities\Utilities;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Contains poll handler methods
 */
class PollHandler {

	const USER_POLL_SUBMITTED_KEY = 'ep-poll-submitted';
	/**
	 * Register hooks
	 */
	public function __construct() {
		add_filter( 'template_include', __CLASS__ . '::filter_template', 100 );
		add_action( 'wp_ajax_ep_poll_submit', __CLASS__ . '::poll_submit' );
		add_action( 'wp_ajax_nopriv_ep_poll_submit', __CLASS__ . '::poll_submit' );
	}

	/**
	 * Filter poll on the front end
	 *
	 * @since v1.0.0
	 *
	 * @param string $template  template path.
	 *
	 * @return string  template path
	 */
	public static function filter_template( string $template ): string {
		$plugin_data = EasyPoll::plugin_data();
		if ( get_post_type() === EasyPollPost::post_type() ) {
			$poll_template = trailingslashit( $plugin_data['templates'] ) . 'easy-poll.php';
			if ( file_exists( $poll_template ) ) {
				$template = $poll_template;
			}
		}
		return $template;
	}

	/**
	 * Render the poll template
	 *
	 * @since v1.0.0
	 *
	 * @param int  $poll_id  poll id.
	 * @param bool $echo  echo or not.
	 *
	 * @return string if echo false;
	 */
	public static function render_poll( int $poll_id, $echo = true ) {
		ob_start();
		Utilities::load_template( 'poll-form.php', $poll_id );
		if ( $echo ) {
			echo ob_get_clean(); //phpcs:ignore
		} else {
			return ob_get_clean();
		}
	}

	/**
	 * Handle poll submission
	 *
	 * @since v1.0.0
	 *
	 * @return wp_json response
	 */
	public static function poll_submit() {
		// Verify nonce.
		Utilities::verify_nonce();
		$field_ids = array_map(
			function( $arr ) {
				return (int) sanitize_text_field( $arr );
			},
			$_POST['ep-poll-field-id']
		);
		$feedback  = array();

		foreach ( $field_ids as $field_id ) {
			$user_feedback = isset( $_POST[ 'question-' . $field_id ] ) ? wp_unslash( sanitize_text_field( $_POST[ 'question-' . $field_id ] ) ) : '';
			// If multiple choice/array type then make string.
			if ( is_array( $user_feedback ) ) {
				$user_feedback = implode( ',', $user_feedback );
			}
			$data = array(
				'field_id' => $field_id,
				'user_id'  => get_current_user_id(),
				'feedback' => $user_feedback,
				'user_ip'  => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
			);
			array_push( $feedback, $data );
		}
		$save = Feedback::save_feedback( $feedback );
		return $save ? wp_send_json_success() : wp_send_json_error();
	}

	/**
	 * Check poll status by the start & expire datetime
	 *
	 * @since 1.1.0
	 *
	 * @param mixed $start_datetime false|string(y-m-d H:i:s).
	 * @param mixed $expire_datetime false|string(y-m-d H:i:s).
	 *
	 * @return string poll status poll-active|poll-expired|poll-upcoming
	 */
	public static function check_poll_status( $start_datetime, $expire_datetime ): string {
		if ( '' === $start_datetime ) {
			$start_datetime = false;
		}
		if ( '' === $expire_datetime ) {
			$expire_datetime = false;
		}
		$poll_status = 'poll-active';
		// If poll start time not set then start right away.
		if ( false !== $start_datetime ) {
			// Check if poll expire date. False means expire date not set.
			if ( false !== $expire_datetime && ( time() >= strtotime( $expire_datetime ) ) ) {
				$poll_status = 'poll-expired';
			} elseif ( time() < strtotime( $start_datetime ) ) {
				$poll_status = 'poll-upcoming';
			}
		} else {
			// If poll start datetime set.
			if ( time() < strtotime( $start_datetime ) ) {
				$poll_status = 'poll-upcoming';
			} else {
				// Expire time not set.
				if ( false === $expire_datetime ) {
					$poll_status = 'poll-active';
				} elseif ( time() >= strtotime( $expire_datetime ) ) {
					$poll_status = 'poll-expired';
				} elseif ( time() >= strtotime( $start_datetime ) && time() < strtotime( $expire_datetime ) ) {

					$poll_status = 'poll-active';
				}
			}
		}
		return $poll_status;
	}
}

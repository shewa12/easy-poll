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
use EasyPoll\FormBuilder\FormField;
use EasyPoll\Utilities\Utilities;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Contains poll handler methods
 */
class PollHandler {

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
	 * @return void wp_json response
	 */
	public static function poll_submit() {
		// Verify nonce.
		Utilities::verify_nonce();
		$post      = $_POST; // phpcs:disable WordPress.Security.NonceVerification.Missing
		$field_ids = $post['ep-poll-field-id'];
		$feedback  = array();

		foreach ( $field_ids as $field_id ) {
			$user_feedback = isset( $post[ 'question-' . $field_id ] ) ? $post[ 'question-' . $field_id ] : '';
			// If multiple choice/array type then make string.
			if ( is_array( $user_feedback ) ) {
				$user_feedback = implode( ',', $user_feedback );
			}
			$data = array(
				'field_id' => $field_id,
				'user_id'  => get_current_user_id(),
				'feedback' => $user_feedback,
				'user_ip'  => $_SERVER['REMOTE_ADDR'],
			);
			array_push( $feedback, $data );
		}
		$save = Feedback::save_feedback( $feedback );
		return $save ? wp_send_json_success() : wp_send_json_error();
	}
}

<?php //phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Filter easy-poll CTP column
 *
 * @since v1.0.0
 *
 * @package EasyPoll\CustomPosts
 */

namespace EasyPoll\CustomPosts;

use EasyPoll\FormBuilder\Feedback;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Manage column filters
 */
class FilterEasyPollColumns {

	/**
	 * Post type
	 *
	 * @var $post_type
	 */
	protected static $post_type;

	/**
	 * Register hooks
	 *
	 * @since v1.0.0
	 */
	public function __construct() {
		self::$post_type = EasyPollPost::post_type();
		$post_type       = self::$post_type;
		add_filter( "manage_{$post_type}_posts_columns", __CLASS__ . '::filter_columns' );

		add_action( 'manage_posts_custom_column', __CLASS__ . '::custom_column_cb', 10, 2 );
	}

	/**
	 * Filter columns to add custom column on the table list
	 *
	 * @since v1.0.0
	 *
	 * @param array $columns  default columns.
	 *
	 * @return array  modified columns
	 */
	public static function filter_columns( array $columns ): array {
		$modify_columns                     = array();
		$modify_columns['title']            = __( 'Title', 'easy-poll' );
		$modify_columns['short_code']       = __( 'Short code', 'easy-poll' );
		$modify_columns['total_submission'] = __( 'Total Submission', 'easy-poll' );
		$modify_columns['author']           = __( 'Author', 'easy-poll' );
		$modify_columns['date']             = __( 'Date', 'easy-poll' );

		// @ep-filter-hook.
		return apply_filters( 'easy-poll-post-columns', $modify_columns );
	}

	/**
	 * Callback function for custom column
	 *
	 * Will be called for each custom columns
	 *
	 * @see https://developer.wordpress.org/reference/hooks/manage_posts_custom_column/
	 *
	 * @since v1.0.0
	 *
	 * @param string $column_name  key name of the column.
	 * @param int    $post_id  post id.
	 *
	 * @return mixed
	 */
	public static function custom_column_cb( string $column_name, int $post_id ) {
		$post_type = get_post_type( $post_id );
		if ( $post_type === self::$post_type ) {
			if ( 'short_code' === $column_name ) {
					echo esc_html( "[{$post_type} id={$post_id}]" );
			}
			if ( 'total_submission' === $column_name ) {
				$total = Feedback::total_submission( $post_id );
				$submission_url = add_query_arg( array( 'page' => 'submissions-list' ) );
				if ( $total ) {
					echo "<a href='" . esc_url( $submission_url ) . "' title='" . esc_attr( 'View Details', 'easy-poll' ) . "'>
					" . esc_html( $total ) . '
					</a>';
				} else {
					echo esc_html( $total );
				}
			}
		}
	}
}

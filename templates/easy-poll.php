<?php
/**
 * Easy poll template
 *
 * Render a poll on the frontend
 *
 * @since v1.0.0
 *
 * @package EasyPoll\Templates
 */

use EasyPoll\CustomPosts\PostCallBack;
use EasyPoll\PollHandler\PollHandler;
use EasyPoll\Settings\Options;
use EasyPoll\FormBuilder\Feedback;
use EasyPoll\Utilities\Utilities;

get_header();

// @ep-action-hooks.
do_action( 'easy-poll-before-poll-render', get_the_ID() );

$poll_id      = get_the_ID();
$is_container = Options::get_option( 'ep-container-width', 'yes' );
$is_container = 'yes' === $is_container ? 'ep-container' : '';

$max_width = Options::get_option( 'ep-max-width', '50' );
$max_width = wp_is_mobile() ? '92%' : "{$max_width}%";

$multiple_select_text = Options::get_option( 'ep-select-multiple-text' );
$thumbnail_size       = Options::get_option( 'ep-thumbnail-size', 'medium' );

$allow_guest       = Options::get_option( 'ep-allow-guest', 'no' );
$already_submitted = Feedback::is_user_already_submitted( $poll_id );

$poll_datetime = PostCallBack::get_poll_datetime( $poll_id );

$utc_start_time = $poll_datetime->start_datetime ? Utilities::get_gmt_date_from_timezone_date( $poll_datetime->start_datetime, $poll_datetime->timezone ) : false;

$utc_expire_time = $poll_datetime->expire_datetime ? Utilities::get_gmt_date_from_timezone_date( $poll_datetime->expire_datetime, $poll_datetime->timezone ) : false;

$plugin_data = EasyPoll::plugin_data();
?>

<div class="<?php echo esc_attr( "ep-poll-wrapper {$is_container}" ); ?>" style="max-width: <?php echo esc_attr( $max_width ); ?>">
<?php
	// If guest not allowed & user not logged in then return.
if ( 'no' === $allow_guest && ! is_user_logged_in() ) {
	ob_start();
	Utilities::load_template(
		'components/alert.php',
		array(
			'class' => 'ep-alert ep-alert-warning',
			'title' => __( 'Permission Denied', 'easy-poll' ),
			'desc'  => __( 'Guest are not allowed for participating the Poll. Please log-in to participate.', 'easy-poll' ),
		)
	);
	//phpcs:ignore
	echo apply_filters( 'easy_poll_guest_not_allowed_template', ob_get_clean() );
	// Closing the above opened div.
	echo '</div>'; //phpcs:ignore
	return;
}

	// Check if user already submitted poll.
if ( $already_submitted ) {
	ob_start();
	Utilities::load_template(
		'components/alert.php',
		array(
			'class' => 'ep-alert ep-alert-danger',
			'title' => __( 'Poll Already Submitted', 'easy-poll' ),
			'desc'  => __( 'The Poll you are trying access is already submitted', 'easy-poll' ),
		)
	);
	//phpcs:ignore
	echo apply_filters( 'easy_poll_already_submitted_template', ob_get_clean() );
	// Closing the above opened div.
	echo '</div>'; //phpcs:ignore
	return;
}

$poll_template_part = PollHandler::check_poll_status( $utc_start_time, $utc_expire_time );
$poll_template_part = $plugin_data['templates'] . "poll-parts/{$poll_template_part}.php";
if ( file_exists( $poll_template_part ) ) {
	Utilities::load_file_from_custom_path(
		$poll_template_part,
		array(
			'poll-id'         => $poll_id,
			'thumbnail-size'  => $thumbnail_size,
			'start_datetime'  => Utilities::get_translated_date( $poll_datetime->start_datetime ),
			'expire_datetime' => Utilities::get_translated_date( $poll_datetime->expire_datetime ),
		)
	);
} else {
	echo esc_html( $poll_template_part ) . esc_html__( ' file not found', 'easy-poll' );
}
?>

</div>

<?php
// @ep-action-hooks.
do_action( 'easy-poll-after-poll-render', get_the_ID() );
get_footer();


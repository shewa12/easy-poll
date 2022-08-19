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
?>
	<h2>
		<?php echo esc_html( get_the_title( $poll_id ) ); ?>
	</h2>

	<?php if ( '' !== get_the_post_thumbnail( $poll_id ) ) : ?>
		<?php echo get_the_post_thumbnail( $poll_id, $thumbnail_size ); ?>
	<?php endif; ?>

	<?php if ( '' !== get_the_content( $poll_id ) ) : ?>
		<div class="ep-poll-contents">
			<?php echo wp_kses_post( get_the_content( $poll_id ) ); ?>
		</div>
	<?php endif; ?>

	<!-- render poll  -->
	<?php PollHandler::render_poll( get_the_ID() ); ?>
	<!-- render poll  -->
</div>

<?php
// @ep-action-hooks.
do_action( 'easy-poll-after-poll-render', get_the_ID() );
get_footer();


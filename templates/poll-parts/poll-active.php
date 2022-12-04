<?php
/**
 * Poll body template
 *
 * @package EasyPoll\Templates
 * @since 1.1.0
 */

use EasyPoll\PollHandler\PollHandler;

$poll_id        = $data['poll-id'];
$thumbnail_size = $data['thumbnail-size'];
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
	<?php PollHandler::render_poll( $poll_id ); ?>
<!-- render poll  -->

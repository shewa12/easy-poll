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

get_header();

// @ep-action-hooks.
do_action( 'easy-poll-before-poll-render', get_the_ID() );
?>

<div class="ep-poll-wrapper">
	<h2>
		<?php the_title(); ?>
	</h2>

	<?php if ( '' !== get_the_post_thumbnail() ) : ?>
		<?php the_post_thumbnail(); ?>
	<?php endif; ?>

	<?php if ( '' !== get_the_content() ) : ?>
		<div class="ep-poll-contents">
			<?php the_content(); ?>
		</div>
	<?php endif; ?>

	<div class="ep-poll-questions">

	</div>
</div>

<?php
// @ep-action-hooks.
do_action( 'easy-poll-after-poll-render', get_the_ID() );
get_footer();
?>

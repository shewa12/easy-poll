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

get_header();

// @ep-action-hooks.
do_action( 'easy-poll-before-poll-render', get_the_ID() );

PollHandler::render_poll( get_the_ID() );
?>

<?php
// @ep-action-hooks.
do_action( 'easy-poll-after-poll-render', get_the_ID() );
get_footer();


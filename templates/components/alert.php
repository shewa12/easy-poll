<?php
/**
 * Alert template
 *
 * @since v1.0.0
 *
 * @package EasyPoll\Templates
 *
 * Usage: load template with below param
 * array( 'class' => '', 'title' => '', 'desc' => '' ).
 *
 * This template assume above params has passed while loading
 */

?>

<div class="<?php echo esc_attr( $data['class'] ); ?>">
	<strong>
		<?php echo esc_html( $data['title'] ); ?>
	</strong>
	<p>
		<?php echo esc_html( $data['desc'] ); ?>
	</p>
</div>

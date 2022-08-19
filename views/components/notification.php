<?php
/**
 * Notification view component
 *
 * @since v1.0.0
 *
 * @package EasyPoll\Views
 */

?>
<div id="<?php echo esc_attr( $data['id'] ); ?>" class="<?php echo esc_attr( $data['class'] ); ?>"> 
	<p>
		<strong>
			<?php echo esc_html( $data['text'] ); ?>
		</strong>
	</p>
	<button type="button" class="notice-dismiss">
		<span class="screen-reader-text">Dismiss this notice.</span>
	</button>
</div>

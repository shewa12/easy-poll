<?php
/**
 * Meta box for building poll
 *
 * @since v1.0.0
 * @package EasyPoll\Metabox
 */

?>
<div class="ep-meta-box-wrapper">
	<form action="">
		<div class="ep-row">
			<div class="ep-col">
				<input type="text" id="ep-field-label" name="ep-field-label">
			</div>
			<div class="ep-col">
				<select name="ep-field-type" id="ep-field-type">
					<option value="single">Single Choice</option>
				</select>
			</div>
			<div class="ep-col">
				<button class="ep-btn btn-danger">
					<i class="dashicons dashicons-remove"></i>
					<?php esc_html_e( 'Remove', 'easy-poll' ); ?>
				</button>
			</div>
		</div>
	</form>
</div>


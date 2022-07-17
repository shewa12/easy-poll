<?php
/**
 * Meta box for building poll
 *
 * @since v1.0.0
 * @package EasyPoll\Metabox
 */

use EasyPoll\FormBuilder\FormField;

?>
<?php do_action( 'ep_before_poll_builder_meta_box', get_the_ID() ); ?>
<div class="ep-meta-box-wrapper ep-wrapper">
	<div class="ep-d-flex ep-gap-10">
		<button type="button" class="ep-btn ep-btn-sm ep-mt-10 ep-modal-opener" data-target="#single-multiple-choice-modal">
			<i class="dashicons dashicons-insert"></i>
			<?php esc_html_e( 'Add Question, Single/Multiple Choice', 'easy-poll' ); ?>
		</button>
		<button type="button" class="ep-btn ep-btn-sm ep-btn-success ep-mt-10 ep-modal-opener" data-target="#input-textarea-modal">
			<i class="dashicons dashicons-insert"></i>
			<?php esc_html_e( 'Add Question, Input/Textarea', 'easy-poll' ); ?>
		</button>
	</div>

	<?php
		FormField::load_single_multiple_choice_modal();
	?>
</div>
<?php do_action( 'ep_after_poll_builder_meta_box', get_the_ID() ); ?>

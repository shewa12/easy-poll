<?php
/**
 * Meta box for building poll
 *
 * @since v1.0.0
 * @package EasyPoll\Metabox
 */

use EasyPoll\FormBuilder\FormField;
use EasyPoll\Utilities\Utilities;

?>
<?php do_action( 'ep_before_poll_builder_meta_box', get_the_ID() ); ?>
<div class="ep-meta-box-wrapper ep-wrapper">
	<div class="ep-d-flex ep-gap-10">
		<button type="button" class="ep-btn ep-btn-sm ep-mt-10 ep-modal-opener" data-target="#ep-single-multiple-choice-modal">
			<i class="dashicons dashicons-insert"></i>
			<?php esc_html_e( 'Add Question, Single/Multiple Choice', 'easy-poll' ); ?>
		</button>
		<button type="button" class="ep-btn ep-btn-sm ep-btn-success ep-mt-10 ep-modal-opener" data-target="#ep-input-textarea-modal">
			<i class="dashicons dashicons-insert"></i>
			<?php esc_html_e( 'Add Question, Input/Textarea', 'easy-poll' ); ?>
		</button>
	</div>
	<form action=""></form>
	<form name="ep-modal-form" ep-ajax-modal>
		<input type="hidden" name="action" value="ep_single_multiple_question_create">
		<?php Utilities::create_nonce_field(); ?>
		<?php FormField::load_single_multiple_choice_modal( 'ep-single-multiple-choice-modal' ); ?>
	</form>
	<form name="ep-modal-form" ep-ajax-modal>
		<input type="hidden" name="action" value="ep_input_textarea_question_create">
		<?php Utilities::create_nonce_field(); ?>
		<?php FormField::load_input_textarea_modal( 'ep-input-textarea-modal' ); ?>
	</form>
</div>
<?php do_action( 'ep_after_poll_builder_meta_box', get_the_ID() ); ?>

<?php
/**
 * Meta box for building poll
 *
 * @since v1.0.0
 * @package EasyPoll\Metabox
 */

use EasyPoll\Utilities\Utilities;

?>
<?php do_action( 'ep_before_poll_builder_meta_box', get_the_ID() ); ?>
<div class="ep-meta-box-wrapper ep-wrapper">
	<button type="button" class="ep-btn ep-btn-sm ep-mt-10 ep-modal-opener">
		<i class="dashicons dashicons-insert"></i>
		<?php esc_html_e( 'Add Question', 'easy-poll' ); ?>
	</button>

	<?php
		// Load modal.
		Utilities::load_template( 'components/modal.php' );
	?>
</div>
<?php do_action( 'ep_after_poll_builder_meta_box', get_the_ID() ); ?>

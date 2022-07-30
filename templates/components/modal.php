<?php
/**
 * Reuse able modal
 *
 * Not for using directly, use through Utility loader
 * method & pass the required params.
 *
 * $args: array(
 *  'modal_id' => 'unique modal id' required
 *  'header_title' => '', required
 *  'body_content'  => 'full file path',  required
 *  'footer_buttons' => array(   optional
 *      array(
 *        'footer_buttons' => array(
 *        'text' => '',
 *        'id' => '',
 *        'class' => '',
 *        'type' => '',
 *      )
 *  )
 *   'ajax_action' => '' // if set then ajax request will be send
 *    'alert_id' => ''  // alert div to show response after form submit, dynamically
 *                          inject text and show to the end user.
 * )
 *
 * @package EasyPoll\Templates
 * @since v1.0.0
 */

use EasyPoll\Utilities\Utilities;

if ( ! isset( $data ) ) {
	esc_html_e( 'Modal arguments required', 'easy-poll' );
	return;
}
?>
<!-- Modal -->
<div class="ep-modal-wrapper" aria-hidden="true" id="<?php echo esc_attr( $data['modal_id'] ); ?>">

	<div class="ep-modal-dialog">
	  <div class="ep-modal-content">
			<div class="ep-modal-header ep-row ep-justify-between ep-align-center">
			  <h1>
			  <?php echo esc_html( $data['header_title'] ); ?>
			  </h1>
			  <a href="javascript:void(0);" class="btn-close ep-close-modal" aria-hidden="true">
			  &times;
			  </a>
			</div>
			<div class="ep-modal-body">
			  <?php Utilities::load_file_from_custom_path( $data['body_content'], true ); ?>
			</div>
			<div class="ep-modal-footer">
				<div class="ep-row ep-gap-10">
				  <?php if ( is_array( $data['footer_buttons'] ) && count( $data['footer_buttons'] ) ) : ?>
						<?php foreach ( $data['footer_buttons'] as $button ) : ?>
				  <button type="<?php echo esc_attr( $button['type'] ); ?>" class="<?php echo esc_attr( $button['class'] ); ?>" id="<?php echo esc_attr( $button['id'] ); ?>">
							<?php echo esc_html( $button['text'] ); ?>
				  </button>
				  <?php endforeach; ?>
				  <?php endif; ?>
				</div>
			</div>
			<!-- alert div to show response after form submit -->
			<?php if ( isset( $data['alert_id'] ) ) : ?>
			<div id="<?php echo esc_attr( $data['alert_id'] ); ?>" class="ep-alert ep-hidden">

			</div>
			<?php endif; ?>
	  </div>
	</div>
</div>

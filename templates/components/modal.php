<?php
/**
 * Reuse able modal
 *
 * Not for using directly, use through Utility loader
 * method & pass the required params.
 * 
 * $args: array(
 *  'modal_id' => 'unique modal id'
 *  'header_title' => '',
 *  'body_content'  => 'full path',
 *  'footer_buttons' => array(
 *      array(
 *        'footer_buttons' => array(
 *        'text' => '',
 *        'id' => '',
 *        'class' => '',
 *        'type' => ''
 *      )
 *  )
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
        <?php Utilities::load_file_from_custom_path( $data['body_content'] ); ?>
      </div>
      <div class="ep-modal-footer">
        <div class="ep-row ep-gap-10">
            <?php if ( is_array( $data['footer_buttons' ] ) && count( $data['footer_buttons' ] ) ) : ?>
              <?php foreach( $data['footer_buttons'] as $button ) : ?>
                <button type="<?php echo esc_attr( $button['type'] ); ?>" class="<?php echo esc_attr( $button['class'] ) ?>" id="<?php echo esc_attr( $button['id'] ); ?>">
                  <?php echo esc_html( $button['text'] ); ?>
                </button>
              <?php endforeach; ?>
            <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

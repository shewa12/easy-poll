<?php
/**
 * Modal for creating poll questions
 *
 * @package EasyPoll\Templates
 * @since v1.0.0
 */

use EasyPoll\FormBuilder\FormBuilder;

// Create FormField obj from factory method.
$form_builder = FormBuilder::create( 'FormField' );
$field_types  = $form_builder::field_types();
?>
<!-- Modal -->
<div class="ep-modal-wrapper" aria-hidden="true">
  <div class="ep-modal-dialog">
    <div class="ep-modal-content">
      <div class="ep-modal-header ep-row ep-justify-between ep-align-center">
        <h1>
          <?php esc_html_e( 'Add Question', 'tutor-periscope' ); ?>
        </h1>
        <a href="JavaScript:Void(0);" class="btn-close ep-close-modal" aria-hidden="true">
          &times;
        </a>
      </div>
      <div class="ep-modal-body">
        <form action="">
          <div class="ep-poll-fields-holder">
            <div class="ep-row ep-justify-between ep-pt-10 ep-align-end">
            <div class="ep-form-group ep-col-10">
              <label for="ep-field-label">
                <?php esc_html_e( 'Question Text', 'easy-poll' ); ?>
              </label>
              <input type="text" id="ep-field-label" class="ep-mt-10" name="ep-field-label" placeholder="<?php esc_html_e( 'Write field label...', 'easy-poll' ); ?>">
            </div>
            <div class="ep-form-group">
              <select name="ep-field-type[]" id="ep-field-type">
                <?php foreach ( $field_types as $key => $field ) : ?>
                  <option value="<?php esc_attr( $field['value'] ); ?>" title="<?php echo esc_html( $field['label'] ); ?>">
                    <?php echo esc_html( $field['label'] ); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          </div>
          <button type="button" id="ep-field-add-more" class="ep-btn ep-btn-sm ep-mt-10">
            <i class="dashicons dashicons-insert"></i>
            <?php esc_html_e( 'Add More', 'easy-poll' ); ?>
          </button>
        </form>
      </div>
      <div class="ep-modal-footer">
        <div class="ep-row ep-gap-10">
          <button class="ep-btn">
            <?php esc_html_e( 'Save & close', 'easy-poll' ); ?>
          </button>
          <button class="ep-btn ep-btn-secondary">
            <?php esc_html_e( 'Save & add more', 'easy-poll' ); ?>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
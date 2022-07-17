<?php
/**
 * Single/Multiple choice fields template
 *
 * @package EasyPoll\Views
 *
 * @since v1.0.0
 */
use EasyPoll\FormBuilder\FormBuilder;

// Create FormField obj from factory method.
$form_builder = FormBuilder::create( 'FormField' );
$field_types  = $form_builder::field_types();
?>
<form action="">
	<div class="ep-poll-options-holder">
		<div class="ep-row ep-justify-between ep-pt-10 ep-align-end">
			<div class="ep-form-group ep-col-10">
				<label for="ep-field-label">
				<?php esc_html_e( 'Question Text', 'easy-poll' ); ?>
				</label>
				<input type="text" id="ep-field-label" class="ep-mt-10" name="ep-field-label" placeholder="<?php esc_html_e( 'Write question...', 'easy-poll' ); ?>">
			</div>
			<div class="ep-form-group">
				<select name="ep-field-type" id="ep-field-type">
				<?php foreach ( $field_types as $key => $field ) : ?>
                    <?php
                        $field_type = $field['value'];
                        if ( '' === $field_type || 'input' === $field_type || 'textarea' === $field_type ) {
                            continue;
                        }    
                    ?>
					<option value="<?php esc_attr( $field['value'] ); ?>" title="<?php echo esc_html( $field['label'] ); ?>">
					<?php echo esc_html( $field['label'] ); ?>
					</option>
				<?php endforeach; ?>
				</select>
			</div>
		</div>
        <div class="ep-row ep-justify-between ep-pt-10 ep-remove-able-wrapper">
            <div class="ep-form-group ep-col-8">
                <input type="text" name="ep-field-option[]" placeholder="Write option...">
            </div>
            <div class="ep-form-group ep-row">
                <button type="button" class="ep-btn ep-btn-danger ep-btn-sm ep-ml-10 ep-remove-able">
                    <i class="dashicons dashicons-remove"></i>
                    <?php esc_html_e( 'Remove', 'easy-poll' )?>
                </button>
            </div>
        </div>
        <div class="ep-row ep-justify-between ep-pt-10 ep-remove-able-wrapper">
            <div class="ep-form-group ep-col-8">
                <input type="text" name="ep-field-option[]" placeholder="Write option...">
            </div>
            <div class="ep-form-group ep-row">
                <button type="button" class="ep-btn ep-btn-danger ep-btn-sm ep-ml-10 ep-remove-able">
                    <i class="dashicons dashicons-remove"></i>
                    <?php esc_html_e( 'Remove', 'easy-poll' )?>
                </button>
            </div>
        </div>
	</div>
	<button type="button" id="ep-add-more-option" class="ep-btn ep-btn-sm ep-mt-10">
		<i class="dashicons dashicons-insert"></i>
		<?php esc_html_e( 'Add More Option', 'easy-poll' ); ?>
	</button>
</form>

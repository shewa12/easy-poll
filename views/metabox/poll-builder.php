<?php
/**
 * Meta box for building poll
 *
 * @since v1.0.0
 * @package EasyPoll\Metabox
 */

use EasyPoll\FormBuilder\FormBuilder;

// Create FormField obj from factory method.
$form_builder = FormBuilder::create( 'FormField' );
$field_types  = $form_builder::field_types();
?>
<?php do_action( 'ep_before_poll_builder_meta_box', get_the_ID() ); ?>
<div class="ep-meta-box-wrapper">
	<form action="">
		<div class="ep-row">
			<div class="ep-form-group">
				<input type="text" id="ep-field-label" name="ep-field-label">
			</div>
			<div class="ep-form-group">
				<select name="ep-field-type" id="ep-field-type">
					<?php foreach ( $field_types as $key => $field ) : ?>
						<option value="<?php esc_attr( $field['value'] ); ?>" title="<?php echo esc_html( $field['label'] ); ?>">
							<?php echo esc_html( $field['label'] ); ?>
						</option>
					<?php endforeach; ?>
				</select>
				<button class="ep-btn btn-danger">
					<i class="dashicons dashicons-remove"></i>
					<?php esc_html_e( 'Remove', 'easy-poll' ); ?>
				</button>
			</div>
		</div>
	</form>
</div>
<?php do_action( 'ep_after_poll_builder_meta_box', get_the_ID() ); ?>


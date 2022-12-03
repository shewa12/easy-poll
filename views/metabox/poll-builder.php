<?php
/**
 * Meta box for building poll
 *
 * @since v1.0.0
 * @package EasyPoll\Metabox
 */

use EasyPoll\CustomPosts\PostCallBack;
use EasyPoll\FormBuilder\FormField;
use EasyPoll\Utilities\Utilities;

$fields    = FormField::get_poll_fields_with_option( get_the_ID() );
$timezones = Utilities::timezone_lists();
$datetime  = json_decode( get_post_meta( get_the_ID(), PostCallBack::POLL_DATETIME_META_KEY, true ) );

?>
<?php do_action( 'ep_before_poll_builder_meta_box', get_the_ID() ); ?>
<div class="ep-meta-box-wrapper ep-wrapper">
	<div class="ep-expire-date-wrapper ep-d-flex ep-align-center ep-gap-10 ep-mt-10">
		<div class="ep-start-datetime ep-d-flex ep-flex-column">
			<label for="ep-start-datetime" class="ep-col-1">
				<?php esc_html_e( 'Start Date Time', 'easy-poll' ); ?>
			</label>
			<input type="datetime-local" name="ep-start-datetime" class="ep-mt-10" id="ep-start-datetime" value="<?php echo esc_attr( $datetime->start_datetime ); ?>"/>
		</div>
		<div class="ep-end-datetime ep-d-flex ep-flex-column">
			<label for="ep-expire-datetime" class="ep-col-1">
				<?php esc_html_e( 'Expire Date Time', 'easy-poll' ); ?>
			</label>
			<input type="datetime-local" name="ep-expire-datetime" class="ep-mt-10" id="ep-expire-datetime" value="<?php echo esc_attr( $datetime->expire_datetime ); ?>"/>
		</div>
		<div class="ep-date-timezone ep-d-flex ep-flex-column">
			<label for="ep-date-timezone" class="ep-col-1">
				<?php esc_html_e( 'Timezone', 'easy-poll' ); ?>
			</label>
			<select name="ep-date-timezone" class="ep-mt-10" id="ep-date-timezone" style="max-width: 250px;">
				<?php foreach ( $timezones as $key => $timezone ) : ?>
					<option value="<?php echo esc_html( $key ); ?>" <?php selected( $datetime->timezone, $key ); ?>>
						<?php echo esc_html( $timezone ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<div class="ep-d-flex ep-gap-10 ep-mt-20">
		<button type="button" class="ep-btn ep-btn-sm ep-mt-10 ep-modal-opener" data-target="#ep-single-multiple-choice-modal">
			<i class="dashicons dashicons-insert"></i>
			<?php esc_html_e( 'Add Question, Single/Multiple Choice', 'easy-poll' ); ?>
		</button>
		<button type="button" class="ep-btn ep-btn-sm ep-btn-success ep-mt-10 ep-modal-opener" data-target="#ep-input-textarea-modal">
			<i class="dashicons dashicons-insert"></i>
			<?php esc_html_e( 'Add Question, Input/Textarea', 'easy-poll' ); ?>
		</button>
	</div>

	<!-- field listing -->
	<div class="ep-poll-fields-wrapper ep-pt-10">
		<?php if ( is_array( $fields ) && count( $fields ) ) : ?>
			<?php $i = 0; ?>
			<h3>
				<?php esc_html_e( 'Poll Questions', 'easy-poll' ); ?>
			</h3>
			<?php foreach ( $fields as $value ) : ?>
				<?php
				$i++;
				$option_labels = array();
				$options_ids   = array();
				if ( ! is_null( $value->option_ids ) && ! is_null( $value->option_labels ) ) {
					$options_ids   = explode( ',', $value->option_ids );
					$option_labels = explode( ',', $value->option_labels );
				}
				$delete_warning_msg = is_null( $value->feedback_id ) ? __( 'Do you want to delete this question?', 'easy-poll' ) : __( 'Warning: Questions & their feedback will be deleted permanently!', 'easy-poll' );
				?>
				<div class="ep-remove-able-wrapper">
					<div class="ep-row ep-justify-between ep-mt-20">
						<div class="ep-form-group ep-col-10 ep-d-flex ep-gap-10 ep-justify-between" data-serial="<?php echo esc_attr( $i ); ?>">
							<strong data-field-id="<?php echo esc_attr( $value->id ); ?>">
								<?php echo esc_html( 'Q' . $i . ') ' . $value->field_label ); ?>
								(<?php echo esc_html( ucfirst( str_replace( '_', ' ', $value->field_type ) ) ); ?>)
							</strong>
						</div>
						<div class="ep-form-group ep-d-flex ep-gap-10">
							<button type="button" class="ep-btn ep-btn-danger ep-btn-sm ep-field-delete" data-field-id="<?php echo esc_attr( $value->id ); ?>" data-warning="<?php echo esc_attr( $delete_warning_msg ); ?>">
								<?php esc_html_e( 'Delete', 'easy-poll' ); ?>
							</button>
						</div>
					</div>
					<!-- field options -->
					<?php if ( is_array( $option_labels ) && count( $option_labels ) ) : ?>
						<div class="ep-field-options-wrapper ep-ml-30">
							<?php foreach ( $option_labels as $key => $option_label ) : ?>
							<div class="ep-field-options d-flex">
							<ul>
								<li>
									<?php echo esc_attr( $option_label ); ?>
								</li>
							</ul>
							</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<!-- field options -->
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<!-- field listing end -->

	<!-- modals for creating fields -->
	<form action=""></form>
	<form name="ep-modal-form" ep-ajax-modal>
		<input type="hidden" name="action" value="ep_single_multiple_question_create">
		<input type="hidden" name="poll-id" value="<?php the_ID(); ?>">
		<?php Utilities::create_nonce_field(); ?>
		<?php FormField::load_single_multiple_choice_modal( 'ep-single-multiple-choice-modal' ); ?>
	</form>
	<form name="ep-modal-form" ep-ajax-modal>
		<input type="hidden" name="action" value="ep_input_textarea_question_create">
		<input type="hidden" name="poll-id" value="<?php the_ID(); ?>">
		<?php Utilities::create_nonce_field(); ?>
		<?php FormField::load_input_textarea_modal( 'ep-input-textarea-modal' ); ?>
	</form>
	<!-- modals for creating fields end -->
</div>
<?php do_action( 'ep_after_poll_builder_meta_box', get_the_ID() ); ?>

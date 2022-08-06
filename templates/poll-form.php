<?php
/**
 * Poll form template
 *
 * @since v1.0.0
 *
 * @package EasyPoll\Templates
 */

use EasyPoll\FormBuilder\FormField;
use EasyPoll\Settings\Options;
use EasyPoll\Utilities\Utilities;

if ( ! isset( $data ) ) {
	die( esc_html_e( 'Invalid poll id', 'easy-poll' ) );
} else {
	$poll_id = $data;
}
$is_container = Options::get_option( 'ep-container-width', 'yes' );
$is_container = 'yes' === $is_container ? 'ep-container' : '';

$max_width = Options::get_option( 'ep-max-width', '50' );
$max_width = wp_is_mobile() ? '92%' : "{$max_width}%";

$multiple_select_text = Options::get_option( 'ep-select-multiple-text' );
$thumbnail_size       = Options::get_option( 'ep-thumbnail-size', 'medium' );

$allow_guest = Options::get_option( 'ep-allow-guest', 'no' );
?>
<div class="<?php echo esc_attr( "ep-poll-wrapper {$is_container}" ); ?>" style="max-width: <?php echo esc_attr( $max_width ); ?>">
	<?php
	// If guest not allowed & user not logged in then return.
	if ( 'no' === $allow_guest && ! is_user_logged_in() ) {
		ob_start();
		Utilities::load_template(
			'components/alert.php',
			array(
				'class' => 'ep-alert ep-alert-warning',
				'title' => __( 'Permission Denied', 'easy-poll' ),
				'desc'  => __( 'Guest are not allowed for participating the Poll. Please log-in to participate.', 'easy-poll' ),
			)
		);
		//phpcs:ignore
		echo apply_filters( 'easy_poll_guest_not_allowed_template', ob_get_clean() );
		// Closing the above opened div.
		echo '</div>'; //phpcs:ignore
		return;
	}
	?>
	<h2>
		<?php echo esc_html( get_the_title( $poll_id ) ); ?>
	</h2>

	<?php if ( '' !== get_the_post_thumbnail( $poll_id ) ) : ?>
		<?php echo get_the_post_thumbnail( $poll_id, $thumbnail_size ); ?>
	<?php endif; ?>

	<?php if ( '' !== get_the_content( $poll_id ) ) : ?>
		<div class="ep-poll-contents">
			<?php echo wp_kses_post( get_the_content( $poll_id ) ); ?>
		</div>
	<?php endif; ?>
	<?php do_action( 'ep_before_poll_questions', $poll_id ); ?>
	<div class="ep-poll-questions">
		<?php
			$poll_questions = FormField::get_poll_fields_with_option( $poll_id );
		?>
		<?php if ( is_array( $poll_questions ) && count( $poll_questions ) ) : ?>
			<form method="post" id="ep-poll-form">
			<?php Utilities::create_nonce_field(); ?>
				<?php foreach ( $poll_questions as $question ) : ?>
					<?php
					$i = 0;
					$i++;
					$option_labels = array();
					$options_ids   = array();
					if ( ! is_null( $question->option_ids ) && ! is_null( $question->option_labels ) ) {
						$options_ids   = explode( ',', $question->option_ids );
						$option_labels = explode( ',', $question->option_labels );
					}
					$field_type = $question->field_type;
					$field_id   = $question->id;
					$field_name = 'ep-poll-question-' . $field_id;
					?>
					<input type="hidden" name="ep-poll-field-id[]" value="<?php echo esc_attr( $field_id ); ?>">
					<div class="ep-row">
						<!-- input-type-field -->
						<?php if ( 'input' === $field_type ) : ?>
						<div class="ep-poll-field-group ep-d-flex ep-flex-column">
							<label for="<?php echo esc_attr( 'question-' . $field_id ); ?>">
								<?php echo esc_html( $question->field_label ); ?>
							</label>
							<input type="text" name="<?php echo esc_attr( 'question-' . $field_id ); ?>" id="<?php echo esc_attr( 'question-' . $field_id ); ?>" placeholder="" value="<?php esc_attr( $field_id ); ?>">
						</div>
						<?php endif; ?>
						<!-- input-type-field -->

						<!-- textarea-type-field -->
						<?php if ( 'textarea' === $field_type ) : ?>
						<div class="ep-poll-field-group ep-d-flex ep-flex-column">
							<label for="<?php echo esc_attr( 'question-' . $field_id ); ?>">
								<?php echo esc_html( $question->field_label ); ?>
							</label>
							<textarea type="text" name="<?php echo esc_attr( 'question-' . $field_id ); ?>" id="<?php echo esc_attr( 'question-' . $field_id ); ?>" rows="3" placeholder=""></textarea>
						</div>
						<?php endif; ?>
						<!-- textarea-type-field -->

						<!-- single-choice -->
						<?php
						if ( 'single_choice' === $field_type || 'multiple_choice' === $field_type ) :
							$hint = 'multiple_choice' === $field_type ? $multiple_select_text : '';
							?>
						
						<div class="ep-poll-options">
							<div class="ep-poll-field-group">
								<label>
									<?php echo esc_html( $question->field_label . $hint ); ?>
								</label>
								<div class="ep-single-choice">
									<?php
									foreach ( $option_labels as $k => $option ) :
										$option_id         = $options_ids[ $k ];
										$option_type       = 'single_choice' === $field_type ? 'radio' : 'checkbox';
										$option_field_name = 'single_choice' === $field_type ? 'question-' . $field_id : 'question-' . $field_id . '[]';
										?>
										<div class="ep-each-option">
											<input type="<?php echo esc_attr( $option_type ); ?>" name="<?php echo esc_attr( $option_field_name ); ?>" id="<?php echo esc_attr( $option_id ); ?>" value="<?php echo esc_attr( $option ); ?>">
											<label for="<?php echo esc_attr( $option_id ); ?>">
												<?php echo esc_html( $option ); ?>
											</label>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
						<?php endif; ?>
						<!-- single-choice -->
						

					</div>
				<?php endforeach; ?>
				<button class="ep-btn" name="submit">
					<?php esc_html_e( 'Submit', 'easy-poll' ); ?>
				</button>
			</form>
			<?php else : ?>
				<strong>
					<?php esc_html_e( 'Questions not available', 'easy-poll' ); ?>
				</strong>
		<?php endif; ?>
	</div>
</div>

<?php
/**
 * Poll submission list
 *
 * @since v1.0.0
 *
 * @package EasyPoll\Report
 */

use EasyPoll\FormBuilder\FormBuilder;
use EasyPoll\Report\Report;

$report  = new Report();
$poll_id = $_GET['poll-id'] ?? 0; //phpcs:ignore

if ( ! $poll_id ) {
	die( esc_html_e( 'Invalid Poll id', 'easy-poll' ) );
}
$submission_lists = $report->get_submission_list( $poll_id );

?>
<div class="wrap">
	<?php if ( is_array( $submission_lists ) && count( $submission_lists ) ) : ?>

		<?php foreach ( $submission_lists as $key => $list ) : ?>
		<div class="ep-card">
			<div class="ep-card-header">
				<h4>
					User Name: Shewa, IP: 797945845
				</h4>
			</div>
			<div class="ep-card-body">
			<?php
				$questions    = explode( '__', $list->questions );
				$types        = explode( '__', $list->question_types );
				$question_ids = explode( '__', $list->question_ids );
				$builder      = FormBuilder::create( 'FieldOptions' );
				$feedback     = explode( '__', $list->user_feedback );
			?>
			<?php foreach ( $questions as $k => $q ) : ?>
				<?php
				$q_type          = ucfirst( str_replace( '_', ' ', $types[ $k ] ) );
				$question_id     = $question_ids[ $k ];
				$single_feedback = $feedback[ $k ];
				?>
				<div class="ep-question-feedback-wrapper">
					<div class="ep-questions-wrapper">
						<strong>
						<?php echo esc_html( "$q ({$q_type})" ); ?>
						</strong>
						<p>
						<?php if ( 'single_choice' === $types[ $k ] || 'multiple_choice' === $types[ $k ] ) : ?>
							
							<?php esc_html_e( 'Options: ', 'easy-poll' ); ?>
							<?php echo esc_html( $builder->get_options_by_field_id( $question_id ) ); ?>
							
						<?php endif; ?>
						</p>
					</div>
					<!-- feedback  -->
					<div class="ep-user-feedback-wrapper">
						<p>
							<strong>
								<?php esc_html_e( 'User Feedback', 'easy-poll' ); ?>
							</strong>
							<?php echo esc_html( $single_feedback ); ?>
						</p>
					</div>
					<!-- feedback end -->
				</div>
			<?php endforeach; ?> 
			</div>
		</div>
		<?php endforeach; ?>

	<?php else : ?>
		<div class="">
			<p>
				<?php esc_html_e( 'No record available', 'easy-poll' ); ?>
			</p>
		</div>
	<?php endif; ?>
</div>

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
			<table class="wp-list-table widefat fixed striped table-view-list posts">
				<div>
					<span>
						<?php esc_html_e( 'User Info: ', 'easy-poll' ); ?>
						<strong>
							<?php echo esc_html( $list->user_id ); ?>
						</strong>
					</span>
				</div>
				<thead>
						<th scope="col" class="manage-column">
							<span>
								<?php esc_html_e( 'Questions', 'easy-poll' ); ?>
							</span>
						</th>
						<th scope="col" class="manage-column">
							<span>
								<?php esc_html_e( 'Question Types', 'easy-poll' ); ?>
							</span>
						</th>
						<th scope="col" class="manage-column">
							<span>
								<?php esc_html_e( 'Options', 'easy-poll' ); ?>
							</span>
						</th>
						<th scope="col" class="manage-column">
							<span>
								<?php esc_html_e( 'Feedback', 'easy-poll' ); ?>
							</span>
						</th>
					</tr>
				</thead>
				<tbody id="the-list">
					<tr>
						<td>
							<?php
								$questions = explode( '__', $list->questions );
							?>
							<?php foreach ( $questions as $q ) : ?>
								<li>
									<?php echo esc_html( $q ); ?>
								</li>
							<?php endforeach; ?>
						</td>
						<td>
							<?php
								$types = explode( '__', $list->question_types );
							?>
							<?php foreach ( $types as $t ) : ?>
								<li>
									<?php echo esc_html( ucfirst( str_replace( '_', ' ', $t ) ) ); ?>
								</li>
							<?php endforeach; ?>                            
						</td>
						<td>
							<?php
								$options = FormBuilder::create( 'FieldOptions' );

							?>
						</td>
						<td>
							<?php
								$feedback = explode( '__', $list->user_feedback );
							?>
							<?php foreach ( $feedback as $f ) : ?>
								<li>
									<?php echo esc_html( $f ); ?>
								</li>
							<?php endforeach; ?>                            
						</td>
					</tr>
				</tbody>
			</table>
		<?php endforeach; ?>

	<?php else : ?>
		<div class="">
			<p>
				<?php esc_html_e( 'No record available', 'easy-poll' ); ?>
			</p>
		</div>
	<?php endif; ?>
</div>

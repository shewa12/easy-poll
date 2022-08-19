<?php
/**
 * Poll submission list
 *
 * @since v1.0.0
 *
 * @package EasyPoll\Report
 */

use EasyPoll\CustomPosts\EasyPollPost;
use EasyPoll\FormBuilder\FormBuilder;
use EasyPoll\Report\Report;

$poll_id = (int) isset( $_GET['poll-id'] ) ? sanitize_text_field( $_GET['poll-id'] ) : 0;

$report = new Report();

$current_page     = isset( $_GET['paged'] ) ? (int) $_GET['paged'] : 1;
$item_per_page    = 20;
$offset           = ( $item_per_page * $current_page ) - $item_per_page;
$submission_lists = $report->get_submission_list( $poll_id, $item_per_page, $offset );
$total_count      = $report->count_submissions( $poll_id );

$polls = EasyPollPost::get_polls();
?>
<div class="wrap ep-d-flex ep-flex-column ep-gap-10">
	<!-- form  -->
	<form action="" id="ep-report-form">
		<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-top" class="screen-reader-text">
				<?php esc_html_e( 'Select Poll', 'easy-poll' ); ?>
			</label>
			<select name="poll-id" id="bulk-action-selector-top">
				<?php if ( $polls->have_posts() ) : ?>
					<?php
					while ( $polls->have_posts() ) :
						$polls->the_post();
						?>
						<option value="<?php the_ID(); ?>" <?php selected( $poll_id, get_the_ID() ); ?>>
							<?php the_title(); ?>
						</option>
					<?php endwhile; ?>
				<?php else : ?>
					<option value="">
						<?php esc_html_e( 'Poll not available', 'easy-poll' ); ?>
					</option>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			</select>
			<input type="submit" id="doaction" class="button action" value="<?php esc_attr_e( 'Apply', 'easy-poll' ); ?>">
		</div>
	</form>
	<!-- form end -->

	<?php if ( is_array( $submission_lists ) && count( $submission_lists ) ) : ?>
		<div class="ep-submission-lists">
			<?php foreach ( $submission_lists as $key => $list ) : ?>
				<?php
				$user      = get_userdata( $list->user_id );
				$user_ip   = $list->user_ip;
				$user_name = '';
				if ( is_a( $user, 'WP_User' ) ) {
					$user_name = '' === $user->display_name ? $user->display_name : $user->user_login;
				}
				?>
			<div class="ep-card">
				<div class="ep-card-header ep-d-flex ep-justify-between ep-align-center ep-collapse" data-target="#card-<?php echo esc_attr( $key ); ?>">
					<h4>
						<?php echo esc_html__( 'User Name: ' . $user_name ); ?>
						<?php echo esc_html__( 'User IP: ' . $user_ip ); ?>
					</h4>
					<i class="dashicons dashicons-arrow-down-alt2"></i>
				</div>
				<div class="ep-card-body ep-hidden" id="card-<?php echo esc_attr( $key ); ?>">
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
								<?php esc_html_e( 'Q) ', 'easy-poll' ); ?>
							</strong>
							<span>
								<?php echo esc_html( "$q ({$q_type})" ); ?>
							</span>
							<p>
							<?php if ( 'single_choice' === $types[ $k ] || 'multiple_choice' === $types[ $k ] ) : ?>
								
								<strong>
								<?php esc_html_e( 'Options: ', 'easy-poll' ); ?>
								</strong>
								<?php echo esc_html( $builder->get_options_by_field_id( $question_id ) ); ?>
								
							<?php endif; ?>
							</p>
						</div>
						<!-- feedback  -->
						<div class="ep-user-feedback-wrapper">
							<p>
								<strong>
									<?php esc_html_e( 'Feedback', 'easy-poll' ); ?>
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
		</div>
		<!-- pagination start -->
		<?php if ( $total_count ) : ?>
			<div class="ep-submission-pagination ep-pagination">
				<?php
					$big = 999999999; // Need an unlikely integer.
					$base = html_entity_decode( str_replace( $big, '%#%', esc_url( admin_url( $big ) . "admin.php?page=ep-report&poll-id={$poll_id}&paged=%#%" ) ) );

					// phpcs:ignore
					echo paginate_links(
						array(
							'base'    => $base,
							'format'  => '?paged=%#%',
							'current' => max( 1, $current_page ),
							'total'   => $item_per_page ? ceil( $total_count / $item_per_page ) : 1,
						)
					);
				?>
			</div>
		<?php endif; ?>
		<!-- pagination end -->
	<?php else : ?>
		<!-- check if user poll set id, not set means user just visiting page -->
		<?php if ( $poll_id ) : ?>
		<div class="">
			<p>
				<?php esc_html_e( 'No record available', 'easy-poll' ); ?>
			</p>
		</div>
		<?php endif; ?>
	<?php endif; ?>
</div>

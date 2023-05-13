<?php
/**
 * Report poll submission list
 *
 * @since 1.2.0
 * @package EasyPoll\Views
 * @subpackage EasyPoll\ReportSummary
 */

use EasyPoll\Report\Report;
use EasyPoll\Utilities\Utilities;

$poll_id = Utilities::sanitize_get_field( 'poll-id' );
if ( ! $poll_id ) {
	$poll_id = get_the_ID();
}

$report      = new Report();
$statistics  = $report->get_poll_percentage_statistics( $poll_id );
$plugin_data = EasyPoll::plugin_data();

?>
<div class="ep-card ep-px-20 ep-pb-20">
	<h3>
		<?php echo esc_html( get_the_title( $poll_id ) ); ?>
	</h3>
	<div>
		<?php
			$poll_post = get_post( $poll_id );
			echo wp_kses_post( $poll_post->post_content );
		?>
	</div>
	<?php if ( is_array( $statistics ) && count( $statistics ) ) : ?>
		<?php
			$question_index = 0;
			$questions      = array_unique( array_column( $statistics, 'field_label' ) );
		foreach ( $questions as $key => $question ) :
			$question_index++;
			?>
		<div class="ep-mt-20">
			<p>
				<strong>
					<?php echo esc_html( 'Q.' . $question_index . ') ' ) . esc_html( $question ); ?>
				</strong>
			</p>
			<?php
			$progress_bar_template = $plugin_data['views'] . 'report/progress-bar.php';
			if ( file_exists( $progress_bar_template ) ) {
				include $progress_bar_template;
			}
			?>
		</div>
		<?php endforeach; ?>
	<?php else : ?>
		<p>
			<?php esc_html_e( 'No data found', 'easy-poll' ); ?>
		</p>
	<?php endif; ?>
</div>



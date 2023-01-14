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

$poll_id     = Utilities::sanitize_get_field( 'poll-id' );
$report      = new Report();
$statistics  = $report->get_poll_percentage_statistics( $poll_id );
$plugin_data = EasyPoll::plugin_data();
?>
<div class="ep-card ep-px-20 ep-pb-20">

	<?php if ( is_array( $statistics ) && count( $statistics ) ) : ?>
		<?php
			$questions = array_unique( array_column( $statistics, 'field_label' ) );
		foreach ( $questions as $key => $question ) :
			?>
		<div>
			<h3>
				<?php echo esc_html( 'Q.' . $key + 1 . ') ' ) . esc_html( $question ); ?>
			</h3>
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



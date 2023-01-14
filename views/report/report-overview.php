<?php
/**
 * Report overview
 *
 * @since 1.2.0
 * @package EasyPoll\Views
 * @subpackage EasyPoll\ReportOverview
 */

use EasyPoll\Report\Report;

$statistics = Report::get_poll_statistics();
?>
<?php do_action( 'ep_before_polls_overview' ); ?>
<div class="ep-card ep-p-10">
	<h3>
		<?php esc_html_e( 'Polls Overview', 'easy-poll' ); ?>
	</h3>
	<div class="ep-row">
		<div class="ep-card ep-p-20  ep-col-4">
			<p>
				<?php esc_html_e( 'Active', 'easy-poll' ); ?>
			</p>
			<strong class="ep-text-extra-large">
				<?php echo esc_html( $statistics->active ); ?>
			</strong>
		</div>
		<div class="ep-card ep-p-20  ep-col-4">
			<p>
				<?php esc_html_e( 'Upcoming', 'easy-poll' ); ?>
			</p>
			<strong class="ep-text-extra-large">
				<?php echo esc_html( $statistics->upcoming ); ?>
			</strong>
		</div>
		<div class="ep-card ep-p-20 ep-col-4">
			<p>
			<?php esc_html_e( 'Expired', 'easy-poll' ); ?>
			</p>
			<strong class="ep-text-extra-large">
				<?php echo esc_html( $statistics->expired ); ?>
			</strong>
		</div>
	</div>
	<!-- active polls chart  -->
	<div class="ep-row ep-active-polls-chart ep-mt-20 ep-justify-between ep-align-center">
		<h3>
			<?php esc_html_e( 'Statistics of Active Polls', 'easy-poll' ); ?>
		</h3>
		<div>
			<?php
			$report_days = '<h3> ' . __( 'Last 7 Days Report', 'easy-poll' ) . ' <h3>';
			// @ep_report_days filter-hook.
			echo wp_kses_post( apply_filters( 'ep_report_days', $report_days ) );
			?>
		</div>
	</div>
	<div class="ep-row">
		<div id="ep-loading-msg"></div>
		<canvas id="ep-active-polls-chart"></canvas>
	</div>
	<?php do_action( 'ep_after_active_polls_chart' ); ?>
	<!-- active polls chart end -->
</div>


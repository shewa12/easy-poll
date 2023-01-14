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
	<div class="ep-row ep-active-polls-chart ep-mt-20">
		<h3>
			<?php esc_html_e( 'Last 7 Days Report of Active Polls', 'easy-poll' ); ?>
		</h3>
	</div>
	<div class="ep-row">
		<div id="ep-loading-msg"></div>
		<canvas id="ep-active-polls-chart"></canvas>
	</div>
	<!-- active polls chart end -->
</div>


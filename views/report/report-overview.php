<?php
/**
 * Report overview
 *
 * @since 1.2.0
 * @package EasyPoll\Views
 * @subpackage EasyPoll\ReportOverview
 */

?>
<div class="ep-card ep-p-10">
	<h3>
		<?php esc_html_e( 'Polls Overview', 'easy-poll' ); ?>
	</h3>
	<div class="ep-row">
		<div class="ep-card ep-p-20  ep-col-4">
			<p>
				<?php esc_html_e( 'Active Polls', 'easy-poll' ); ?>
			</p>
			<strong class="ep-text-extra-large">100</strong>
		</div>
		<div class="ep-card ep-p-20  ep-col-4">
			<p>
				<?php esc_html_e( 'Upcoming Polls', 'easy-poll' ); ?>
			</p>
			<strong class="ep-text-extra-large">100</strong>
		</div>
		<div class="ep-card ep-p-20 ep-col-4">
			<p>
			<?php esc_html_e( 'Expired Polls', 'easy-poll' ); ?>
			</p>
			<strong class="ep-text-extra-large">100</strong>
		</div>
	</div>
	<!-- active polls chart  -->
	<div class="ep-row ep-active-polls-chart ep-mt-20">
		<h3>
			<?php esc_html_e( 'Last 7 Days Report of Active Polls', 'easy-poll' ); ?>
		</h3>
	</div>
	<div class="ep-row">
		<canvas id="ep-active-polls-chart"></canvas>
	</div>
	<!-- active polls chart end -->
</div>


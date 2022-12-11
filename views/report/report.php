<?php
/**
 * Report page
 *
 * Manage summary & list view report
 *
 * @since v1.2.0
 *
 * @package EasyPoll\Views
 */

use EasyPoll\CustomPosts\EasyPollPost;
use EasyPoll\Report\Report;
use EasyPoll\Utilities\Utilities;


$poll_id      = (int) Utilities::sanitize_get_field( 'poll-id' );
$report_type  = Utilities::sanitize_get_field( 'report-type' );
$polls        = EasyPollPost::get_polls();
$report_types = Report::get_report_types();

?>
<div class="wrap ep-d-flex ep-flex-column ep-gap-10">
	<!-- form  -->
	<form action="" method="get" id="ep-report-form">
		<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-top" class="screen-reader-text">
				<?php esc_html_e( 'Select Poll', 'easy-poll' ); ?>
			</label>
			<select name="poll-id" id="bulk-action-selector-top">
				<?php if ( $polls->have_posts() ) : ?>
					<option value="">
						<?php esc_html_e( 'Select a poll', 'easy-poll' ); ?>
					</option>
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
			<select name="ep-report-type">
				<?php foreach ( $report_types as $key => $value ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $report_type, $key ); ?>>
						<?php echo esc_html( $value ); ?>
					</option>
				<?php endforeach; ?>
			</select>
			<input type="submit" id="doaction" class="button action" value="<?php esc_attr_e( 'Apply', 'easy-poll' ); ?>">
		</div>
	</form>
	<!-- form end -->

	<!-- load report view based on report type -->
	<?php
	$plugin_data = EasyPoll::plugin_data();
	$report_view = $plugin_data['views'] . 'report/' . $report_type . '.php';

	if ( file_exists( $report_view ) ) {
		Utilities::load_file_from_custom_path( $report_view );
	}
	?>
	<!-- load report view based on report type end -->
</div>

<?php
/**
 * Template part of poll-summary
 *
 * It is dependent on statistics & question var
 *
 * @since 1.2.0
 * @package EasyPoll\Views
 * @subpackage EasyPoll\ReportSummary
 */

?>
<?php foreach ( $statistics as $statistic ) : ?>
	<?php
	if ( $question !== $statistic->field_label ) {
		continue;
	}
	$progress = (int) $statistic->percentage;
	?>
	<div class="ep-d-flex ep-progress-bar-wrapper">
		<div class="ep-col-10 ep-progress-bar ep-mb-10">
			<div class="ep-progress ep-progress-<?php echo esc_attr( $progress ); ?>" style="width: <?php echo (int) esc_attr( $progress ) . '%'; ?>">
			</div>
			<span class="ep-progress-text">
				<?php echo esc_html( $statistic->option_label ); ?>
			</span>
		</div>
		<div class="ep-col-2 ep-percentage ep-pl-10">
			<strong style="font-size: 16px;">
				<?php echo esc_html( (int) $statistic->percentage . '%' ); ?>
			</strong>
		</div>
	</div>
<?php endforeach; ?>

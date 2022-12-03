<?php
/**
 * Upcoming poll template
 *
 * @package EasyPoll\Templates
 * @since 1.1.0
 */

use EasyPoll\Utilities\Utilities;

$plugin_data = EasyPoll::plugin_data();
?>
<div class="ep-upcoming-poll-wrapper">
	<?php
		$content = 'Poll will be started at {time}';
		$content = str_replace( '{time}', $data['start_datetime'], $content );

		Utilities::load_file_from_custom_path(
			$plugin_data['templates'] . 'components/alert.php',
			array(
				'class' => 'ep-alert',
				'title' => __( 'Poll has not been Started Yet', 'easy-poll' ),
				'desc'  => $content,
			)
		);
		?>
</div>

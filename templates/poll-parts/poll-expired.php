<?php
/**
 * Expire poll template
 *
 * @package EasyPoll\Templates
 * @since 1.1.0
 */

use EasyPoll\Utilities\Utilities;

$plugin_data = EasyPoll::plugin_data();
?>
<div class="ep-expire-poll-wrapper">
	<?php
		$content = 'Poll has been expired at {time}';
		$content = str_replace( '{time}', $data['expire_datetime'], $content );

		Utilities::load_file_from_custom_path(
			$plugin_data['templates'] . 'components/alert.php',
			array(
				'class' => 'ep-alert ep-alert-warning',
				'title' => __( 'Poll has been Expired', 'easy-poll' ),
				'desc'  => $content,
			)
		);
		?>
</div>

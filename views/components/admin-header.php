<?php
/**
 * Admin page header component
 *
 * @since 1.2.0
 * @package EasyPoll\Components
 */

$page_title = $data['page-title'];
?>
<div class="ep-card ep-admin-header" style="margin-left: -20px;width: 100%;padding-left: 20px;">
	<h3>
		<?php echo esc_html( $page_title ); ?>
	</h3>
</div>

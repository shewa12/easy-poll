<?php
/**
 * Validation error component
 *
 * @package EasyPoll\Components
 * @since 1.1.0
 */

use EasyPoll\ErrorHandler\ErrorHandler;

$validation_errors = ErrorHandler::get_errors();

?>
<?php if ( is_array( $validation_errors ) && count( $validation_errors ) ) : ?>
<div class="ep-validation-error-wrapper">
	<div class="ep-alert ep-alert-warning">
		<strong>
			<?php esc_html_e( 'Validation Error', 'easy-poll' ); ?>
		</strong>
		<?php foreach ( $validation_errors as $v_error ) : ?>
			<li>
				<?php echo esc_html( $v_error ); ?>
			</li>
			<?php
		endforeach;
		ErrorHandler::destroy_errors();
		?>
	</div>
</div>
<?php endif; ?>

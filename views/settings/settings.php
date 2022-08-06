<?php
/**
 * Settings page
 *
 * @since v1.0.0
 *
 * @package EasyPoll\Views
 */

use EasyPoll\Settings\Options;

// @ep-action-hook.
do_action( 'easy_poll_before_settings_view' );

$options = Options::get_settings_options();
?>
<div class="wrap">
	<form action="" method="post">
		<table class="form-table" role="presentation">
			<?php foreach ( $options as $option ) : ?>
				<tr>
					<th>
						<?php echo esc_html( $option['label'] ); ?>
					</th>
					<td>
						<?php if ( 'input' === $option['field_type'] ) : ?>
							<input type="text" name="<?php esc_html( $option['option_name'] ); ?>" class="regular-text" value="<?php echo esc_attr( $option['default'] ); ?>">
						<?php endif; ?>

						<?php if ( 'radio' === $option['field_type'] ) : ?>
							<?php foreach ( $option['options'] as $label ) : ?>
								<input type="radio" name="<?php esc_html( $option['option_name'] ); ?>" class="regular-text" value="<?php echo esc_attr( $label['value'] ); ?>">
								<label for="">
									<?php echo esc_html( $label['label'] ); ?>
								</label>
							<?php endforeach; ?>
						<?php endif; ?>

						<?php if ( 'dropdown' === $option['field_type'] ) : ?>
							<select type="radio" name="<?php esc_html( $option['option_name'] ); ?>" class="regular-text" value="<?php echo esc_attr( $label['value'] ); ?>">
								<?php foreach ( $option['options'] as $label ) : ?>
								<option value="<?php echo esc_attr( $label['value'] ); ?>">
									<?php echo esc_html( $label['label'] ); ?>
								</option>
								<?php endforeach; ?>
							</select>
						<?php endif; ?>

						<?php if ( 'textarea' === $option['field_type'] ) : ?>
							<textarea type="radio" name="<?php esc_html( $option['option_name'] ); ?>" class="regular-text" value="<?php echo esc_attr( $label['value'] ); ?>"><?php echo esc_html( $option['default'] ); ?></textarea>
						<?php endif; ?>

						<p class="description">
							<?php echo esc_html( $option['description'] ); ?>
						</p>
						
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
		<p>
			<button type="submit" name="submit" class="button button-primary">
				<?php esc_html_e( 'Save Changes', 'easy-poll' ); ?>
			</button>
		</p>
	</form>
</div>
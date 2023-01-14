<?php
/**
 * Settings page
 *
 * @since v1.0.0
 *
 * @package EasyPoll\Views
 */

use EasyPoll\Settings\Options;
use EasyPoll\Utilities\Utilities;

// @ep-action-hook.
do_action( 'easy_poll_before_settings_view' );

$options  = Options::get_settings_options();
$settings = get_option( Options::OPTION_KEY, false );

if ( ! $settings ) {
	die( esc_html_e( 'Invalid settings, try re-install the plugin', 'easy-poll' ) );
}

$plugin_data = EasyPoll::plugin_data();
$page_header = $plugin_data['views'] . 'components/admin-header.php';

// Loading page header.
Utilities::load_views(
	'components/admin-header.php',
	array(
		'page-title' => __( 'Settings', 'easy-poll' ),
	)
);
?>
<div class="wrap">
	<form action="" method="post" id="ep-setting-form">
		<?php Utilities::create_nonce_field(); ?>
		<input type="hidden" name="action" value="ep_settings_update">
		<table class="form-table" role="presentation">
			<?php foreach ( $options as $option ) : ?>
				<?php
					$option_value = $settings[ $option['option_name'] ] ?? '';
				?>
				<tr>
					<th>
						<?php echo esc_html( $option['label'] ); ?>
					</th>
					<td>
						<?php if ( 'input' === $option['field_type'] ) : ?>
							<input type="text" name="<?php echo esc_html( $option['option_name'] ); ?>" class="regular-text" value="<?php echo esc_attr( $option_value ); ?>">
						<?php endif; ?>
			
						<?php if ( 'number' === $option['field_type'] ) : ?>
							<input type="number" name="<?php echo esc_html( $option['option_name'] ); ?>" class="regular-text" value="<?php echo esc_attr( $option_value ); ?>">
						<?php endif; ?>

						<?php if ( 'radio' === $option['field_type'] ) : ?>
							<?php foreach ( $option['options'] as $label ) : ?>
								<input type="radio" name="<?php echo esc_html( $option['option_name'] ); ?>" class="regular-text" value="<?php echo esc_attr( $label['value'] ); ?>" <?php echo esc_attr( $option_value === $label['value'] ? 'checked' : '' ); ?>>
								<label for="">
									<?php echo esc_html( $label['label'] ); ?>
								</label>
							<?php endforeach; ?>
						<?php endif; ?>

						<?php if ( 'dropdown' === $option['field_type'] ) : ?>
							<select type="radio" name="<?php echo esc_html( $option['option_name'] ); ?>" class="regular-text" value="<?php echo esc_attr( $label['value'] ); ?>">
								<?php foreach ( $option['options'] as $label ) : ?>
								<option value="<?php echo esc_attr( $label['value'] ); ?>" <?php selected( $option_value, $label['value'] ); ?>>
									<?php echo esc_html( $label['label'] ); ?>
								</option>
								<?php endforeach; ?>
							</select>
						<?php endif; ?>

						<?php if ( 'textarea' === $option['field_type'] ) : ?>
							<textarea type="radio" name="<?php echo esc_html( $option['option_name'] ); ?>" class="regular-text" value="<?php echo esc_attr( $label['value'] ); ?>"><?php echo esc_html( $option_value ); ?></textarea>
						<?php endif; ?>

						<div class="description">
							<?php
							$desc_lines = explode( '\n', $option['description'] );
							foreach ( $desc_lines as $desc ) {
								?>
									<p class="description">
									<?php
									echo wp_kses(
										$desc,
										Utilities::allowed_tags()
									);
									?>
									</p>
									<?php
							}
							?>
						</div>
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

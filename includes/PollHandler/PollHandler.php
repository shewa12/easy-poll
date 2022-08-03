<?php
/**
 * Handle poll system, rendering poll on the front end
 * & handle poll submission
 *
 * @since v1.0.0
 *
 * @package EasyPoll\PollHandler
 */

namespace EasyPoll\PollHandler;

use EasyPoll;
use EasyPoll\CustomPosts\EasyPollPost;
use EasyPoll\FormBuilder\FormField;
use EasyPoll\Utilities\Utilities;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Contains poll handler methods
 */
class PollHandler {

	/**
	 * Register hooks
	 */
	public function __construct() {
		add_filter( 'template_include', __CLASS__ . '::filter_template', 100 );
	}

	/**
	 * Filter poll on the front end
	 *
	 * @since v1.0.0
	 *
	 * @param string $template  template path.
	 *
	 * @return string  template path
	 */
	public static function filter_template( string $template ): string {
		$plugin_data = EasyPoll::plugin_data();
		if ( get_post_type() === EasyPollPost::post_type() ) {
			$poll_template = trailingslashit( $plugin_data['templates'] ) . 'easy-poll.php';
			if ( file_exists( $poll_template ) ) {
				$template = $poll_template;
			}
		}
		return $template;
	}

	/**
	 * Render the poll template
	 *
	 * @since v1.0.0
	 *
	 * @param int  $poll_id  poll id.
	 * @param bool $echo  echo or not.
	 *
	 * @return string if echo false;
	 */
	public static function render_poll( int $poll_id, $echo = true ) {
		ob_start();
		$is_container         = 'ep-container';
		$max_width            = wp_is_mobile() ? '92%' : '50%';
		$multiple_select_text = __( ' ( Select multiple if required ) ', 'easy-poll' );
		$thumbnail_size       = 'medium';
		?>
		<div class="<?php echo esc_attr( "ep-poll-wrapper {$is_container}" ); ?>" style="max-width: <?php echo esc_attr( $max_width ); ?>">
			<h2>
				<?php echo esc_html( get_the_title( $poll_id ) ); ?>
			</h2>

			<?php if ( '' !== get_the_post_thumbnail( $poll_id ) ) : ?>
				<?php echo get_the_post_thumbnail( $poll_id, $thumbnail_size ); ?>
			<?php endif; ?>

			<?php if ( '' !== get_the_content( $poll_id ) ) : ?>
				<div class="ep-poll-contents">
					<?php echo wp_kses_post( get_the_content( $poll_id ) ); ?>
				</div>
			<?php endif; ?>
			<?php do_action( 'ep_before_poll_questions', $poll_id ); ?>
			<div class="ep-poll-questions">
				<?php
					$poll_questions = FormField::get_poll_fields_with_option( $poll_id );
				?>
				<?php if ( is_array( $poll_questions ) && count( $poll_questions ) ) : ?>
					<form action="" method="post">
					<?php Utilities::create_nonce_field(); ?>
						<?php foreach ( $poll_questions as $question ) : ?>
							<?php
							$i = 0;
							$i++;
							$option_labels = array();
							$options_ids   = array();
							if ( ! is_null( $question->option_ids ) && ! is_null( $question->option_labels ) ) {
								$options_ids   = explode( ',', $question->option_ids );
								$option_labels = explode( ',', $question->option_labels );
							}
							$field_type = $question->field_type;
							$field_id   = $question->id;
							$field_name = 'ep-poll-question-' . $field_id;
							?>
							<div class="ep-row">
								<!-- input-type-field -->
								<?php if ( 'input' === $field_type ) : ?>
								<div class="ep-poll-field-group ep-d-flex ep-flex-column">
									<label for="<?php echo esc_attr( 'question-' . $field_id ); ?>">
										<?php echo esc_html( $question->field_label ); ?>
									</label>
									<input type="text" name="<?php echo esc_attr( $field_name ); ?>" id="<?php echo esc_attr( 'question-' . $field_id ); ?>" placeholder="">
								</div>
								<?php endif; ?>
								<!-- input-type-field -->

								<!-- textarea-type-field -->
								<?php if ( 'textarea' === $field_type ) : ?>
								<div class="ep-poll-field-group ep-d-flex ep-flex-column">
									<label for="<?php echo esc_attr( 'question-' . $field_id ); ?>">
										<?php echo esc_html( $question->field_label ); ?>
									</label>
									<textarea type="text" name="<?php echo esc_attr( $field_name ); ?>" id="<?php echo esc_attr( 'question-' . $field_id ); ?>" rows="3" placeholder=""></textarea>
								</div>
								<?php endif; ?>
								<!-- textarea-type-field -->

								<!-- single-choice -->
								<?php
								if ( 'single_choice' === $field_type || 'multiple_choice' === $field_type ) :
									$hint = 'multiple_choice' === $field_type ? $multiple_select_text : '';
									?>
									
								<div class="ep-poll-options">
									<div class="ep-poll-field-group">
										<label>
											<?php echo esc_html( $question->field_label . $hint ); ?>
										</label>
										<div class="ep-single-choice">
											<?php
											foreach ( $option_labels as $k => $option ) :
												$option_id = $options_ids[ $k ];
												$type      = 'single_choice' === $field_type ? 'radio' : 'checkbox';
												?>
												<div class="ep-each-option">
													<input type="<?php echo esc_attr( $type ); ?>" name="<?php echo esc_attr( $field_name ); ?>" id="<?php echo esc_attr( $option_id ); ?>">
													<label for="<?php echo esc_attr( $option_id ); ?>">
														<?php echo esc_html( $option ); ?>
													</label>
												</div>
											<?php endforeach; ?>
										</div>
									</div>
								</div>
								<?php endif; ?>
								<!-- single-choice -->
								

							</div>
						<?php endforeach; ?>
						<button class="ep-btn">
							<?php esc_html_e( 'Submit', 'easy-poll' ); ?>
						</button>
					</form>
					<?php else : ?>
						<strong>
							<?php esc_html_e( 'Questions not available', 'easy-poll' ); ?>
						</strong>
				<?php endif; ?>
			</div>
		</div>
		<?php
		if ( $echo ) {
			echo ob_get_clean(); //phpcs:ignore
		} else {
			return ob_get_clean();
		}
	}
}

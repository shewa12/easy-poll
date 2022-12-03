<?php
/**
 * Register custom posts
 *
 * @package EasyPoll\CustomPosts
 *
 * @since v1.0.0
 */

namespace EasyPoll\CustomPosts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialize custom posts
 */
class InitCustomPosts {

	/**
	 * Register Hooks
	 *
	 * @since v1.0.0
	 */
	public function __construct() {
		add_action( 'init', __CLASS__ . '::init' );

		/**
		 * Register post callback class
		 *
		 * @since 1.1.0
		 */
		self::register_callback_class();
	}

	/**
	 * Init custom posts
	 *
	 * @since v1.0.0
	 *
	 * @return void
	 */
	public static function init(): void {
		$types = array(
			EasyPollPost::class,
		);

		foreach ( $types as $type ) {
			register_post_type(
				$type::post_type(),
				$type::post_args()
			);
		}

		// Modify columns.
		new FilterEasyPollColumns();
	}

	/**
	 * Register post callback class
	 *
	 * @since 1.1.0
	 *
	 * @return void
	 */
	private static function register_callback_class() {
		new PostCallBack();
	}
}

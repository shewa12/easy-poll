<?php
/**
 * Manage rewrite rules
 *
 * @since v1.0.1
 *
 * @package EasyPoll\Settings
 */

namespace EasyPoll\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Do stuff rewrite or flush rules
 */
class RewriteRules {

	/**
	 * Register hook
	 *
	 * @since v1.0.1
	 */
	public function __construct() {
		add_action( 'init', __CLASS__ . '::flush_rewrite_rules' );
	}

	/**
	 * Check if permalink update is required, if so
	 * then update.
	 *
	 * @since v1.0.1
	 *
	 * @return void
	 */
	public static function flush_rewrite_rules(): void {
		$permalink_update_required = (int) get_option( Options::REQUIRE_PERMALINK_UPDATE, 1 );
		if ( $permalink_update_required ) {
			flush_rewrite_rules();
			update_option( Options::REQUIRE_PERMALINK_UPDATE, 0 );
		}
	}
}

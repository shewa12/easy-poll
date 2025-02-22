<?php
/**
 * Initialize settings
 *
 * @since v1.0.0
 *
 * @package EasyPoll\Settings;
 */

namespace EasyPoll\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Settings init class
 */
class Settings {

	/**
	 * Init dependent classes
	 *
	 * @since v1.0.0
	 */
	public function __construct() {
		new Options();
		new RewriteRules();
	}
}

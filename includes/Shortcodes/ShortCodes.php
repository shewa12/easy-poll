<?php
/**
 * ShortCodes Loaders
 *
 * @package EasyPoll\ShortCodes
 *
 * @since v1.0.0
 */

namespace EasyPoll\ShortCodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Init short codes
 */
class ShortCodes {

	/**
	 * Load available short codes
	 *
	 * @since v1.0.0
	 */
	public function __construct() {
		new PollShortCode();
	}
}

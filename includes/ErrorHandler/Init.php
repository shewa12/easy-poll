<?php
/**
 * Initialize error handler
 *
 * @package EasyPoll\ErrorHandler
 * @since 1.1.0
 */

namespace EasyPoll\ErrorHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load error handler class
 *
 * @since 1.1.0
 */
class Init {

	/**
	 * Load dependencies
	 *
	 * @since 1.1.0
	 */
	public function __construct() {
		new ErrorHandler();
	}
}

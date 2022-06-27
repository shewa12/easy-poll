<?php
/**
 * Initialize meta box module
 *
 * @package EasyPoll\Metabox
 *
 * @since v1.0.0
 */

namespace EasyPoll\Metabox;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load meta box dependent method.
 */
class MetaboxInit {

	/**
	 * Load meta boxes
	 *
	 * @since v2.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		new PollBuilderMetabox();
	}
}

<?php
/**
 * Admin module loader
 *
 * @package EasyPoll\Admin
 *
 * @since v2.0.0
 */

namespace EasyPoll\Admin;

use EasyPoll\Admin\Menu\MainMenu;

/**
 * Admin Package loader
 *
 * @since v2.0.0
 */
class Admin {

	/**
	 * Load dependencies
	 *
	 * @since v2.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		new MainMenu();
	}
}

<?php
/**
 * BulkUser Concrete class
 *
 * @package EasyPoll\Admin\SubMenu
 *
 * @author Shewa <shewa12kpi@gmail.com>
 *
 * @since v1.0.0
 */

namespace EasyPoll\Admin\Menu\SubMenu;

use EasyPoll\Admin\Menu\MainMenu;
use EasyPoll\Utilities\Utilities;

/**
 * Polls sub menu
 */
class Settings implements SubMenuInterface {

	/**
	 * Page title
	 *
	 * @since v1.0.0
	 *
	 * @return string  page title
	 */
	public function page_title(): string {
		return __( 'Settings', 'easy-poll' );
	}

	/**
	 * Menu title
	 *
	 * @since v1.0.0
	 *
	 * @return string  menu title
	 */
	public function menu_title(): string {
		return __( 'Settings', 'easy-poll' );
	}

	/**
	 * Capability to access this menu
	 *
	 * @since v1.0.0
	 *
	 * @return string  capability
	 */
	public function capability(): string {
		return 'manage_options';
	}

	/**
	 * Page URL slug
	 *
	 * @since v1.0.0
	 *
	 * @return string  slug
	 */
	public function slug(): string {
		return 'ep-settings';
	}

	/**
	 * Render content for this sub-menu page
	 *
	 * @since v1.0.0
	 *
	 * @return void
	 */
	public function view() {
        Utilities::load_views( 'settings/settings.php' );
	}
}

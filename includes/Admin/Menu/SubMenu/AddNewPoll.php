<?php
/**
 * EvaluationReport Concrete class
 *
 * @package EasyPoll\Admin\SubMenu
 *
 * @author Shewa <shewa12kpi@gmail.com>
 *
 * @since v1.0.0
 */

namespace EasyPoll\Admin\Menu\SubMenu;

/**
 * EvaluationReport sub menu
 */
class AddNewPoll implements SubMenuInterface {

	/**
	 * Page title
	 *
	 * @since v1.0.0
	 *
	 * @return string  page title
	 */
	public function page_title(): string {
		return __( 'Add new Poll', 'easy-poll' );
	}

	/**
	 * Menu title
	 *
	 * @since v1.0.0
	 *
	 * @return string  menu title
	 */
	public function menu_title(): string {
		return __( 'Add New', 'easy-poll' );
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
		return 'easy-poll-add-new';
	}

	/**
	 * Render content for this sub-menu page
	 *
	 * @since v1.0.0
	 *
	 * @return void
	 */
	public function view() {
        echo "Add new";
	}
}

<?php
/**
 * Evaluation form table
 *
 * @package EasyPoll/Database
 *
 * @since v2.0.0
 */

namespace EasyPoll\Database;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * EasyPoll table.
 */
class EasyPolls extends DatabaseTable {

	/**
	 * Course evaluation table name
	 *
	 * @var $table_name
	 */
	private static $table_name = 'easy_polls';

	/**
	 * Get table name
	 *
	 * @since v2.0.0
	 *
	 * @return string
	 */
	public static function get_table(): string {
		return self::$table_name;
	}

	/**
	 * Prepare table, primary key, character set
	 *
	 * @return void
	 *
	 * @since v1.0.0
	 */
	public static function create_table(): void {
		do_action( 'ep_before_easy_polls_table' );
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name      = $wpdb->prefix . self::$table_name;
		$sql             = "CREATE TABLE $table_name (
        id INT(9) unsigned NOT NULL AUTO_INCREMENT,
        poll_title VARCHAR(255),
        poll_description TEXT,
        created_at datetime default CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
        ) ENGINE = INNODB
        $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
		do_action( 'ep_after_easy_polls_table' );
	}

}

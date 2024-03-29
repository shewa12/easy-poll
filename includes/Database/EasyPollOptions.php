<?php
/**
 * Create evaluation feedback form table
 *
 * @package EasyPoll/Database
 *
 * @since v1.0.0
 */

namespace EasyPoll\Database;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Evaluation feedback table
 */
class EasyPollOptions extends DatabaseTable {

	/**
	 * Course evaluation table name
	 *
	 * @var $table_name
	 */
	private static $table_name = 'easy_poll_options';

	/**
	 * Get table name
	 *
	 * @since v1.0.0
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
		do_action( 'ep_before_options_table' );
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();
		$table_name      = $wpdb->prefix . self::$table_name;
		$field_table     = $wpdb->prefix . EasyPollFields::get_table();

		$sql             = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT(9) unsigned NOT NULL AUTO_INCREMENT,
		field_id INT(9) unsigned NOT NULL,

		FOREIGN KEY (field_id)
			REFERENCES $field_table(id)
            ON DELETE CASCADE,
	
        option_label VARCHAR(255),
        PRIMARY KEY  (id)
        ) ENGINE = INNODB
		$charset_collate;";
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
		do_action( 'ep_after_options_table' );
	}

	/**
	 * Drop Table if exists
	 *
	 * @return void
	 */
	public static function drop_table() {
		global $wpdb;
		do_action( 'ep_before_options_table_drop' );
		$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . self::$table_name );
		do_action( 'ep_after_options_table_drop' );
	}
}

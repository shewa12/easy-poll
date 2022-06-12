<?php
/**
 * Create evaluation feedback form table
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
 * Evaluation feedback table
 */
class EasyPollFields extends DatabaseTable {

	/**
	 * Course evaluation table name
	 *
	 * @var $table_name
	 */
	private static $table_name = 'easy_poll_fields';

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
	 * @since v2.0.0
	 */
	public static function create_table(): void {
		do_action( 'ep_before_easy_poll_fields_table' );
		global $wpdb;
		$polls_table = $wpdb->prefix . EasyPolls::get_table();

		$charset_collate = $wpdb->get_charset_collate();
		$table_name      = $wpdb->prefix . self::$table_name;
		$sql             = "CREATE TABLE $table_name (
        id INT(9) unsigned NOT NULL AUTO_INCREMENT,
		poll_id INT(9) unsigned NOT NULL,
        field_label VARCHAR(255),
        field_type VARCHAR(255),

		FOREIGN KEY (poll_id)
			REFERENCES $polls_table(id)
			ON DELETE CASCADE,
		
        PRIMARY KEY  (id)
        ) ENGINE = INNODB
		$charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
		do_action( 'tutor_periscope_after_evaluation_table' );
	}

	/**
	 * Drop Table if exists
	 *
	 * @return void
	 */
	public static function drop_table() {
		global $wpdb;
		do_action( 'ep_before_easy_poll_fiels_table_drop' );
		$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . self::$table_name );
		do_action( 'ep_after_easy_poll_fiels_table_drop' );
	}
}

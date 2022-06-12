<?php
/**
 * Create evaluation form fields table
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
 * Evaluation_Table
 */
class EasyPollFeedback extends DatabaseTable {

	/**
	 * Course evaluation table name
	 *
	 * @var $table_name
	 */
	private static $table_name = 'easy_poll_feedback';

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
		do_action( 'ep_before_easy_poll_feedback_table' );
		global $wpdb;
		$field_table = $wpdb->prefix . EasyPollFields::get_table();

		$charset_collate = $wpdb->get_charset_collate();
		$table_name      = $wpdb->prefix . self::$table_name;
		$sql             = "CREATE TABLE $table_name (
        id INT(9) unsigned NOT NULL AUTO_INCREMENT,
		field_id INT(9) unsigned NOT NULL,

        FOREIGN KEY (field_id)
		    REFERENCES $field_table(id)
            ON DELETE CASCADE,

		user_id INT(9) NOT NULL,
        feedback TEXT,
        PRIMARY KEY  (id)
        )  ENGINE = INNODB
        $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
		do_action( 'ep_after_easy_poll_feedback_table' );
	}

	/**
	 * Drop Table if exists
	 *
	 * @return void
	 */
	public static function drop_table() {
		global $wpdb;
		do_action( 'ep_before_easy_poll_feedback_table_drop' );
		$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . self::$table_name );
		do_action( 'ep_after_easy_poll_feedback_table_drop' );
	}
}

<?php
/**
 * Database table creation trait
 *
 * @package EasyPoll\Tests
 */

namespace EasyPoll\Tests\Utilities;

use EasyPoll\Database\EasyPollFeedback;
use EasyPoll\Database\EasyPollFields;
use EasyPoll\Database\EasyPollOptions;

trait DatabaseTrait {

	/**
	 * Create tables from EasyPoll
	 *
	 * @return void
	 */
	public static function create_tables(): void {
		$tables = array(
			EasyPollFields::class,
			EasyPollFeedback::class,
			EasyPollOptions::class,
		);

		foreach ( $tables as $table ) {
			$table::create_table();
		}
	}
}

<?php
/**
 * Feedback test
 *
 * @package EasyPoll\FeedbackTest
 */

namespace EasyPoll\Tests\PHPUnit;

use EasyPoll\Database\EasyPollFeedback;
use EasyPoll\FormBuilder\Feedback;
use EasyPoll\Tests\PHPUnit\BaseTest;
use EasyPoll\Tests\Utilities\DatabaseTrait;
use EasyPoll\Tests\Utilities\PollBuilderTrait;

/**
 * Test feedback class methods
 */
class FeedbackTest extends BaseTest {

	/**
	 * Database trait for creating tables
	 */
	use DatabaseTrait;
	use PollBuilderTrait;

	/**
	 * Setup some stuff before any test execution
	 *
	 * @return void
	 */
	public static function setUpBeforeClass():void {
		self::create_tables();
		self::input_textarea_question_create();
	}

	/**
	 * Test table name
	 *
	 * @return void
	 */
	public function test_table_name() {
		global $wpdb;
		$expected = $wpdb->prefix . EasyPollFeedback::get_table();
		$actual   = Feedback::get_table();

		$this->assertSame( $expected, $actual );
	}

	/**
	 * Check save functionalities
	 *
	 * @return void
	 */
	public function test_save_feedback() {
		
	}
}

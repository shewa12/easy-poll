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
use EasyPoll\Tests\Utilities\WPFactoryWrapperTrait;

/**
 * Test feedback class methods
 */
class FeedbackTest extends BaseTest {

	/**
	 * Database trait for creating tables
	 */
	use DatabaseTrait;
	use PollBuilderTrait;
	use WPFactoryWrapperTrait;

	/**
	 * Setup some stuff before any test execution
	 *
	 * @return void
	 */
	public static function setUpBeforeClass():void {
		self::create_tables();
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
	public function test_save_feedback_can_insert_multiple_rows() {
		$fields  = self::get_poll_fields();
		$request = array();
		$user_id = self::create_and_get_user_id();

		foreach ( $fields as $field ) {
			$new_field = array(
				'field_id' => $field->id,
				'user_id'  => $user_id,
				'feedback' => 'Dummy feedback',
				'user_ip'  => '790809',
			);
			array_push( $request, $new_field );
		}
		$this->assertTrue( Feedback::save_feedback( $request ) );
	}

	/**
	 * Check save functionalities can
	 *
	 * @return void
	 */
	public function test_save_feedback_can_insert_single_rows() {
		$fields    = self::get_poll_fields();
		$user_id   = self::create_and_get_user_id();
		$request[] = array(
			'field_id' => $fields[0]->id,
			'user_id'  => $user_id,
			'feedback' => 'Dummy feedback single rows',
			'user_ip'  => '790809',
		);
		$this->assertTrue( Feedback::save_feedback( $request ) );
	}

	/**
	 * Test is_user_already_submitted_poll method
	 *
	 * @return void
	 */
	public function test_is_user_already_submitted_poll() {
		$poll_id = self::create_poll_post();
		$actual  = Feedback::is_user_already_submitted( $poll_id );

		$this->assertTrue( $actual );
	}
}

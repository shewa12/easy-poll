<?php
/**
 * Test PollHandler class methods
 *
 * @package EasyPoll\Tests
 */

namespace EasyPoll\Tests\PHPUnit;

use EasyPoll\PollHandler\PollHandler;

/**
 * PollHandlerTest class
 *
 * @since 1.1.0
 */
class PollHandlerTest extends BaseTest {

	/**
	 * Check poll status by passing '' value
	 *
	 * @return void
	 */
	public function test_check_poll_status_return_poll_active() {
		$start_datetime  = '';
		$expire_datetime = '';

		$expected_value = 'poll-active';
		$actual         = PollHandler::check_poll_status( $start_datetime, $expire_datetime );

		$this->assertSame( $expected_value, $actual );

		$start_datetime  = date_create( 'now' )->format( 'y-m-d H:i:s' );
		$date_add        = date_add( date_create( 'now' ), date_interval_create_from_date_string( '3 day' ) );
		$expire_datetime = $date_add->format( 'y-m-d H:i:s' );

		// Pass different values & test.
		$actual2 = PollHandler::check_poll_status( $start_datetime, $expire_datetime );
		$actual3 = PollHandler::check_poll_status( $start_datetime, false );
		$actual4 = PollHandler::check_poll_status( false, false );

		$this->assertSame( $expected_value, $actual2 );
		$this->assertSame( $expected_value, $actual3 );
		$this->assertSame( $expected_value, $actual4 );
	}

	/**
	 * Check poll status by passing '' value
	 *
	 * @return void
	 */
	public function test_check_poll_status_return_poll_upcoming() {
		$future_time     = date_add( date_create( 'now' ), date_interval_create_from_date_string( '3 day' ) );
		$start_datetime  = $future_time->format( 'y-m-d H:i:s' );

		$expire_datetime = date_add( $future_time, date_interval_create_from_date_string( '5 day' ) );
		$expire_datetime = $expire_datetime->format( 'y-m-d H:i:s' );

		$expected_value = 'poll-upcoming';

		$actual1 = PollHandler::check_poll_status( $start_datetime, false );
		$actual2 = PollHandler::check_poll_status( $start_datetime, '' );
		$actual3 = PollHandler::check_poll_status( $start_datetime, $expire_datetime );
		$actual4 = PollHandler::check_poll_status( $expire_datetime, $start_datetime );

		$this->assertSame( $expected_value, $actual1 );
		$this->assertSame( $expected_value, $actual2 );
		$this->assertSame( $expected_value, $actual3 );
		$this->assertSame( $expected_value, $actual4 );

	}
	/**
	 * Check poll status by passing '' value
	 *
	 * @return void
	 */
	public function test_check_poll_status_return_poll_expired() {
		$expected_value = 'poll-expired';

		// Pass different values & test.
		$actual1 = PollHandler::check_poll_status( false, '2022-02-22' );
		$actual2 = PollHandler::check_poll_status( '', '2022-02-22' );
		$actual3 = PollHandler::check_poll_status( '2022-02-22', '2022-02-25' );

		$this->assertSame( $expected_value, $actual1 );
		$this->assertSame( $expected_value, $actual2 );
		$this->assertSame( $expected_value, $actual3 );
	}

}

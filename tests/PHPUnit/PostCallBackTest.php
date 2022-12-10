<?php
/**
 * Test PostCallBack class
 *
 * @package EasyPoll\Tests
 */

namespace EasyPoll\Tests\PHPUnit;

use EasyPoll\CustomPosts\PostCallBack;
use EasyPoll\Tests\Utilities\WPFactoryWrapperTrait;

/**
 * Test class
 */
class PostCallBackTest extends BaseTest {

	use WPFactoryWrapperTrait;

	/**
	 * Test poll meta update method
	 *
	 * @return void
	 */
	public function test_update_poll_start_expire_datetime() {
		$_POST['start_datetime'] = '2022-12-05T16:59';
		$_POST['start_datetime'] = '2022-12-04T16:59';
		$_POST['start_datetime'] = 'Asia/Dhaka';

		$actual = PostCallBack::update_poll_start_expire_datetime( 2 );
		$this->assertEmpty( $actual );
	}

	/**
	 * Test get_poll_datetime return object
	 * with containing props
	 *
	 * @return void
	 */
	public function test_get_poll_datetime() {
		$poll_id = self::create_and_get_post_id();

		$_POST['start_datetime']  = '2022-12-04T16:59';
		$_POST['expire_datetime'] = '2022-12-05T16:59';
		$_POST['timezone']        = 'Asia/Dhaka';

		$actual = PostCallBack::update_poll_start_expire_datetime( $poll_id );
		$this->assertEmpty( $actual );

		$actual = PostCallBack::get_poll_datetime( $poll_id );
		$expect = array(
			'start_datetime'  => '2022-12-04T16:59',
			'expire_datetime' => '2022-12-05T16:59',
			'timezone'        => 'Asia/Dhaka',
		);
		$expected_keys = array_keys( $expect );

		$this->assertIsObject( $actual );

		$object_vars = get_object_vars( $actual );
		$meta_keys  = array_keys( $object_vars );
		$this->assertEquals( $expected_keys, $meta_keys );
	}
}

<?php
/**
 * Class SampleTest
 *
 * @package Easy_Poll
 */

namespace EasyPoll\Tests\PHPUnit;

use EasyPoll;

/**
 * Sample test case.
 */
class EasyPollTest extends BaseTest {

	private $easy_poll;

	public static function setUpBeforeClass():void {
		
	}

	/**
	 * Test EasyPoll instance
	 *
	 * @return void
	 */
	public function test_instance() {
		$actual = EasyPoll::instance();
		$this->assertInstanceOf( EasyPoll::class, $actual );
	}

	public function test_plugin_data() {
		$actual = EasyPoll::plugin_data();
		$this->assertIsArray( $actual );
		$this->assertArrayHasKey( 'plugin_url', $actual );
	}

}

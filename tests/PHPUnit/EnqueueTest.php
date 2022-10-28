<?php
/**
 * Enqueue class test
 *
 * @package Easy_Poll\Assets
 */

namespace EasyPoll\Tests\PHPUnit;

use EasyPoll\Assets\Enqueue;

/**
 * Test methods
 */
class EnqueueTest extends BaseTest {

	/**
	 * Test script data array index that pass to JS
	 *
	 * @return void
	 */
	public function test_scripts_data_array_index() {
		$scripts_data = Enqueue::scripts_data();
		$actual       = array_keys( $scripts_data );
		$expected     = array( 'url', 'nonce', 'nonce_action', 'success_msg', 'poll_template_width' );

		$this->assertEquals( $expected, $actual );
	}

	/**
	 * Check script data url index value
	 *
	 * @return void
	 */
	public function test_scripts_data_url_value() {
		$scripts_data = Enqueue::scripts_data();
		$actual       = $scripts_data['url'];
		$expected     = 'http://example.org/wp-admin/admin-ajax.php';

		$this->assertSame( $expected, $actual );
	}
}

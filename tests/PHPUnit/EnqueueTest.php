<?php
/**
 * Enqueue class test
 *
 * @package Easy_Poll\Assets
 */

namespace EasyPoll\Tests\PHPUnit;

use EasyPoll;
use EasyPoll\Assets\Enqueue;
use EasyPoll\Settings\Options;

/**
 * Test methods
 */
class EnqueueTest extends BaseTest {

	/**
	 * Set up option
	 *
	 * @return void
	 */
	public static function setUpBeforeClass():void {
		Options::save_default_settings();
	}

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
	public function test_scripts_data_value() {
		$plugin_data  = EasyPoll::plugin_data();
		$scripts_data = Enqueue::scripts_data();
		$actual_url   = $scripts_data['url'];
		$expected_url = 'http://example.org/wp-admin/admin-ajax.php';

		$actual_nonce   = $scripts_data['nonce'];
		$expected_nonce = wp_create_nonce( $plugin_data['nonce'] );

		$this->assertSame( $actual_url, $expected_url );
		$this->assertSame( $actual_nonce, $expected_nonce );
		$this->assertSame( $plugin_data['nonce_action'], $scripts_data['nonce_action'] );

		// Success message & template width testing.
		$this->assertEquals( '60', $scripts_data['poll_template_width'] );
		$this->assertSame( 'Thank you for submitting poll', $scripts_data['success_msg'] );

	}

	public static function tearDownAfterClass():void {
		update_option( Options::OPTION_KEY, '' );
	}

}

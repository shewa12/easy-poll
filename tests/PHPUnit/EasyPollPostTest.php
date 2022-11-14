<?php
/**
 * Test EasyPollPost class
 *
 * @package EasyPoll\Tests
 */

namespace EasyPoll\Tests\PHPUnit;

use EasyPoll\CustomPosts\EasyPollPost;
use WP_Query;

/**
 * Test class methods
 */
class EasyPollPostTest extends BaseTest {

	/**
	 * Instance of EasyPollPost
	 *
	 * @var object
	 */
	private static $easy_poll_post;

	/**
	 * Run before any test executes
	 *
	 * @return void
	 */
	public static function setUpBeforeClass():void {
		self::$easy_poll_post = new EasyPollPost();
	}

	/**
	 * Test post type
	 *
	 * @return void
	 */
	public function test_post_type() {
		$expected = 'easy-poll';
		$this->assertSame( $expected, self::$easy_poll_post::post_type() );
	}

	/**
	 * Test post type
	 *
	 * @return void
	 */
	public function test_post_args() {
        $expected = array(
			'label'           => __( 'Poll', 'easy-poll' ),
			'labels'          => array(
				'name'               => _x( 'Polls', 'post type general name', 'easy-poll' ),
				'singular_name'      => _x( 'Poll', 'post type singular name', 'easy-poll' ),
				'menu_name'          => _x( 'Polls', 'admin menu', 'easy-poll' ),
				'name_admin_bar'     => _x( 'Poll', 'add new on admin bar', 'easy-poll' ),
				'add_new'            => _x( 'Add New', 'tutor Poll add', 'easy-poll' ),
				'add_new_item'       => __( 'Add New Poll', 'easy-poll' ),
				'new_item'           => __( 'New Poll', 'easy-poll' ),
				'edit_item'          => __( 'Edit Poll', 'easy-poll' ),
				'view_item'          => __( 'View Poll', 'easy-poll' ),
				'all_items'          => __( 'Polls', 'easy-poll' ),
				'search_items'       => __( 'Search Polls', 'easy-poll' ),
				'parent_item_colon'  => __( 'Parent Polls:', 'easy-poll' ),
				'not_found'          => __( 'No Polls found.', 'easy-poll' ),
				'not_found_in_trash' => __( 'No Polls found in Trash.', 'easy-poll' ),
			),
			'description'     => __( 'Easy poll custom post type', 'easy-poll' ),
			'public'          => true,
			'show_ui'         => true,
			'show_in_menu'    => 'easy-poll',
			'show_in_rest'    => true,
			'capability_type' => 'post',
			'supports'        => array( 'title', 'editor', 'author', 'thumbnail' ),
		);

        $this->assertSame( $expected, self::$easy_poll_post::post_args() );
	}

	/**
	 * Test post type
	 *
	 * @return void
	 */
	public function test_get_polls_returns_instanceof_wp_query() {
        $expected = \WP_Query::class;
        $this->assertInstanceOf( $expected, self::$easy_poll_post::get_polls() );
	}
}

<?php
/**
 * Easy poll custom post type
 *
 * Register CPT for storing poll
 *
 * @package EasyPoll\CustomPosts
 *
 * @since v1.0.0
 */

namespace EasyPoll\CustomPosts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EasyPollPost {

	/**
	 * Post type
	 *
	 * @var POST_TYPE
	 */
	const POST_TYPE = 'easy-poll';

	/**
	 * Get post type
	 *
	 * @since v1.0.0
	 *
	 * @return string  post type of easy poll
	 */
	public static function post_type(): string {
		return self::POST_TYPE;
	}

	/**
	 * Custom post arguments
	 *
	 * @since v1.0.0
	 *
	 * @return array  args of custom post
	 */
	public static function post_args(): array {
		return array(
			'label'                => __( 'Poll', 'easy-poll' ),
			'labels'               => array(
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
			'description'          => __( 'Easy poll custom post type', 'easy-poll' ),
			'public'               => true,
			'show_ui'              => true,
			'show_in_menu'         => 'easy-poll',
			'show_in_rest'         => true,
			'capability_type'      => 'post',
			'supports'             => array( 'title', 'editor', 'author', 'thumbnail' ),
		);
	}
}

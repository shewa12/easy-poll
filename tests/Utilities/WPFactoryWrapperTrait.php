<?php
/**
 * A wrapper trait of WP Factory builder. Trait method's will
 * wrap factory builder methods to use with ease.
 *
 * @package EasyPoll\Tests
 */

namespace EasyPoll\Tests\Utilities;

trait WPFactoryWrapperTrait {

	/**
	 * Create a user & get it's id
	 *
	 * @param array $args args to create user.
	 *
	 * @return int user id
	 */
	public static function create_and_get_user_id( array $args = array() ):int {
		$default_args = array(
			'role' => 'subscriber',
		);
		$parse_args   = wp_parse_args( $args, $default_args );
		$user_id      = self::factory()->user->create( $parse_args );
		return (int) $user_id;
	}

	/**
	 * Create & get user
	 *
	 * @param array $args args to create user.
	 *
	 * @return mixed user object on success
	 */
	public static function create_and_get_user( array $args = array() ):int {
		$default_args = array(
			'role' => 'subscriber',
		);
		$parse_args   = wp_parse_args( $args, $default_args );
		return self::factory()->user->create_and_get( $parse_args );
	}

	/**
	 * Create a post & get it's id
	 *
	 * @param array $args args to create post.
	 *
	 * @return int post id
	 */
	public static function create_and_get_post_id( array $args = array() ):int {
		$default_args = array(
			'post_title'  => 'Fake post ' . time(),
			'post_type'   => 'post',
			'post_status' => 'publish',
		);
		$parse_args   = wp_parse_args( $args, $default_args );
		$post_id      = self::factory()->post->create( $parse_args );
		return (int) $post_id;
	}

}

<?php //phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Post interface for custom post type
 *
 * @since v1.0.0
 *
 * @package EasyPoll\CustomPosts
 */

namespace EasyPoll\CustomPosts;

/**
 * Custom post interface
 */
interface PostInterface {

	/**
	 * Get post type
	 */
	public static function post_type(): string;

	/**
	 * Get post args
	 */
	public static function post_args(): array;
}

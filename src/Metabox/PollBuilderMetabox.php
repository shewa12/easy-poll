<?php
/**
 * Initialize meta  box on easy-poll post for creating
 * poll system
 *
 * @package EasyPoll\Metabox
 *
 * @since v1.0.0
 */

namespace EasyPoll\Metabox;

use EasyPoll\CustomPosts\EasyPollPost;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Evaluation form meta box
 */
class PollBuilderMetabox extends MetaboxFactory {

	/**
	 * Register hooks
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'register_meta_box' ) );
	}

	/**
	 * Create new meta box, implementation of abstract method
	 *
	 * @since v2.0.0
	 *
	 * @return MetaboxInterface
	 */
	public function create_meta_box(): MetaboxInterface {
		return new Metabox(
			'easy-poll-builder',
			__( 'Create Poll', 'tutor-periscope' ),
			EasyPollPost::post_type(),
			'advanced',
			'low'
		);
	}

	/**
	 * Meta box view
	 *
	 * @since v2.0.0
	 *
	 * @return void
	 */
	public function meta_box_view() {
		echo "hello";
	}
}

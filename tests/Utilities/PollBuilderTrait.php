<?php
/**
 * Build poll for testing
 *
 * @package EasyPoll\Tests
 */

namespace EasyPoll\Tests\Utilities;

use EasyPoll;
use EasyPoll\CustomPosts\EasyPollPost;
use EasyPoll\Database\EasyPollFields;
use EasyPoll\FormBuilder\FormClient;

trait PollBuilderTrait {

	/**
	 * Poll fields cache key name
	 *
	 * @var string
	 */
	public static $field_cache_key = 'ep_poll_fields';

	/**
	 * Create some fake poll's question
	 *
	 * @return mixed
	 */
	public static function input_textarea_question_create() {
		$plugin_data  = EasyPoll::plugin_data();
		$poll_post_id = self::create_poll_post();

		$_POST[ $plugin_data['nonce'] ] = wp_create_nonce( $plugin_data['nonce_action'] );

		$_POST['poll-id']        = $poll_post_id;
		$_POST['ep-field-label'] = array(
			'Label one',
			'Label two',
			'Label there',
		);
		$_POST['ep-field-type']  = array(
			'input',
			'input',
			'textarea',
		);

		$form_client = new FormClient( false );
		return json_decode( $form_client->input_textarea_question_create( $_POST ) );
	}

	/**
	 * Get poll fields array of objects
	 *
	 * @param integer $poll_id if poll id set field will be returned by poll id.
	 *
	 * @return array | false on success it will return array, false otherwise
	 */
	public static function get_poll_fields( int $poll_id = 0 ) {
		global $wpdb;
		$field_table = $wpdb->prefix . EasyPollFields::get_table();

		$where_clause = '';
		if ( $poll_id ) {
			$where_clause = "AND fields.poll_id = $poll_id";
		}

		$field_results = wp_cache_get( self::$field_cache_key );
		if ( false === $field_results ) {
			$field_results = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT *
                        FROM $field_table AS fields
                        WHERE 1 = %d
                            {$where_clause}
                        ORDER BY fields.id DESC
                        LIMIT 3
                    ",
					1
				)
			);
			if ( is_array( $field_results ) && count( $field_results ) ) {
				wp_cache_set( self::$field_cache_key, $field_results );
				return wp_cache_get( self::$field_cache_key );
			} else {
				self::input_textarea_question_create();
				self::get_poll_fields();
			}
		} else {
			return wp_cache_get( self::$field_cache_key );
		}
	}

	/**
	 * Create a poll post
	 *
	 * @return int post id
	 */
	public static function create_poll_post() {
		$post_args = array(
			'post_title' => 'Fake poll post ' . time(),
			'post_type'  => EasyPollPost::POST_TYPE,
		);
		return self::factory()->post->create( $post_args );
	}
}

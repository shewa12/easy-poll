<?php
/**
 * Build poll for testing
 *
 * @package EasyPoll\Tests
 */

namespace EasyPoll\Tests\Utilities;

use EasyPoll;
use EasyPoll\CustomPosts\EasyPollPost;
use EasyPoll\Database\EasyPollFeedback;
use EasyPoll\Database\EasyPollFields;
use EasyPoll\FormBuilder\FormClient;
use EasyPoll\Helpers\QueryHelper;

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

	/**
	 * Create poll if poll id is not provided
	 * create fields against post and then submit
	 * feedback
	 *
	 * @param int   $poll_id  poll post id.
	 * @param array $fields 2 dimensional array containing fields col value.
	 *
	 * @return mixed false if failure, array on success
	 */
	public static function create_poll_questions_feedback( int $poll_id = 0, array $fields = array() ) {
		$response = false;
		if ( ! $poll_id ) {
			$poll_id = self::create_poll_post();
		}
		if ( ! count( $fields ) || ! is_array( $fields[0] ) ) {
			$fields = array(
				array(
					'poll_id'     => $poll_id,
					'field_label' => 'Fake field ' . time(),
					'field_type'  => 'input',
				),
				array(
					'poll_id'     => $poll_id,
					'field_label' => 'Fake field ' . time(),
					'field_type'  => 'textarea',
				),
			);
		}
		$fields_insert_and_get = self::create_poll_fields( $fields );
		if ( is_array( $fields_insert_and_get ) && count( $fields_insert_and_get ) ) {
			// Insert feedback for these fields.
			$feedback = array();
			foreach ( $fields_insert_and_get as $field ) {
				$feedback[] = array(
					'field_id' => $field->id,
					'user_id'  => get_current_user_id(),
					'feedback' => 'Dummy feedback for field ID: ' . $field->id,
					'user_ip'  => '1234',
				);
			}
			// If multi dimensional feedback then insert.
			if ( is_array( $feedback[0] ) ) {
				$insert_feedback = self::insert_feedback( $feedback );
				if ( $insert_feedback ) {
					$response = array(
						'poll_id'  => $poll_id,
						'fields'   => $fields,
						'feedback' => $feedback,
					);
				}
			}
		}
		return $response;
	}

	/**
	 * Create poll fields based on $fields args
	 *
	 * @param array $fields must be 2 dimensional array containing all
	 * columns value.
	 *
	 * @return mixed false on failure, array of obj on success
	 */
	public static function create_poll_fields( array $fields ) {
		global $wpdb;
		$table = $wpdb->prefix . EasyPollFields::get_table();

		// If fields are not multi-dimensional then return.
		if ( ! is_array( $fields[0] ) ) {
			return false;
		}
		$insert = QueryHelper::insert_multiple_rows( $table, $fields );
		if ( $insert ) {
			// Retrieve inserted rows.
			$get_results = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT *
						FROM {$table}
						WHERE 1 = %d
						ORDER BY id DESC
						LIMIT %d
					",
					1,
					count( $fields )
				)
			);
			return $get_results;
		}
		return false;
	}

	/**
	 * Insert multiple feedback together
	 *
	 * @param array $feedback 2 dimensional array to insert feedback.
	 *
	 * @return bool
	 */
	public static function insert_feedback( array $feedback ): bool {
		global $wpdb;
		$feedback_table = $wpdb->prefix . EasyPollFeedback::get_table();
		if ( ! is_array( $feedback[0] ) ) {
			return false;
		}
		return QueryHelper::insert_multiple_rows( $feedback_table, $feedback );
	}
}

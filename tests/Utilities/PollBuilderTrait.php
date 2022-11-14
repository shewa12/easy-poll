<?php
/**
 * Build poll for testing
 *
 * @package EasyPoll\Tests
 */

namespace EasyPoll\Tests\Utilities;

use EasyPoll;
use EasyPoll\CustomPosts\EasyPollPost;
use EasyPoll\FormBuilder\FormClient;

trait PollBuilderTrait {

    /**
     * Create some fake poll's question
     *
     * @return void
     */
    public static function input_textarea_question_create() {
        $plugin_data = EasyPoll::plugin_data();
        $poll_post_id = self::create_poll_post();

       $_POST[ $plugin_data['nonce'] ] =  wp_create_nonce( $plugin_data['nonce_action'] );

        $_POST['poll-id'] = $poll_post_id;
        $_POST['ep-field-label'] = array(
            'Label one',
            'Label two',
            'Label there',
        );
        $_POST['ep-field-type'] = array(
            'input',
            'input',
            'textarea',
        );

        $form_client = new FormClient( false );
        $form_client->input_textarea_question_create( $_POST );

    }

    /**
     * Create a poll post
     *
     * @return int post id
     */
    public static function create_poll_post() {
        $post_args = array(
            'post_title' => 'Fake poll post ' . time(),
            'post_type' => EasyPollPost::POST_TYPE,
        );
        return self::factory()->post->create( $post_args );
    }
}

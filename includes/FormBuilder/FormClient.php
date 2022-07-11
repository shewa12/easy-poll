<?php
/**
 * Form client class is for interacting with form builder
 *
 * @since v1.0.0
 * @package TutorPeriscope\FormBuilder
 */

namespace EasyPoll\FormBuilder;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class FormClient {

	public function __construct() {
		$form_builder = FormBuilder::create( 'FormField' );
	}
}

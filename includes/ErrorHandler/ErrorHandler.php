<?php
/**
 * Manage validation error messages with WP transient
 *
 * @package EasyPoll\ErrorHandler
 * @since 1.1.0
 */

namespace EasyPoll\ErrorHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ErrorHandler class for managing errors
 *
 * @since 1.1.0
 */
class ErrorHandler {

	/**
	 * Transient key for errors
	 *
	 * @since 1.1.0
	 *
	 * @var string
	 */
	const ERRORS_TRANSIENT_KEY = 'ep-errors';

	/**
	 * Set validation errors
	 *
	 * @since 1.1.0
	 *
	 * @param mixed $errors string or array of errors.
	 *
	 * @return void
	 */
	public static function set_errors( $errors ) {
		if ( ! is_array( $errors ) ) {
			$errors = array( $errors );
		}
		set_transient( self::ERRORS_TRANSIENT_KEY, $errors );
	}

	/**
	 * Get array of errors
	 *
	 * @since 1.1.0
	 *
	 * @return array errors
	 */
	public static function get_errors():array {
		$errors = get_transient( self::ERRORS_TRANSIENT_KEY );
		return is_array( $errors ) && count( $errors ) ? $errors : array();
	}

	/**
	 * Destroy errors from transient
	 *
	 * @since 1.1.0
	 *
	 * @return void
	 */
	public static function destroy_errors() {
		delete_transient( self::ERRORS_TRANSIENT_KEY );
	}
}

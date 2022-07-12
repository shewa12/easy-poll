<?php
/**
 * Form builder factory class
 * 
 * @since v1.0.0
 * @package TutorPeriscope\FormBuilder
 */

namespace EasyPoll\FormBuilder;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class FormBuilder {

    /**
     * Create object as per type so that client code can
     * interact with concrete class.
     *
     * @since v1.0.0
     * @return FormInterface
     */
    public static function create( string $type ): FormInterface {
        try {
            $class = "EasyPoll\\FormBuilder\\{$type}";
            return new $class();
        } catch ( \Throwable $th ) {
            echo $th->getMessage();
        }
    }
}

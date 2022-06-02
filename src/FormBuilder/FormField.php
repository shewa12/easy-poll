<?php
/**
 * Form field concrete class
 * 
 * @since v2.0.0
 * @package TutorPeriscope\FormBuilder
 */

namespace EasyPoll\FormBuilder;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use EasyPoll\FormInterface;

class FormField implements FormInterface {

    public function create( array $request ) {

    }

    public function get_one( int $id ): object {

    }

    public function get_list(): array {

    }

    public function update( array $request, int $id): bool {

    }

    public function delete( int $id ): bool {

    }
}
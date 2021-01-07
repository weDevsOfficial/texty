<?php

namespace Texty\Api;

use WP_REST_Controller;

class Base extends WP_REST_Controller {

    /**
     * Permission check
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|bool
     */
    public function admin_permissions_check( $request ) {
        return current_user_can( 'manage_options' );
    }
}

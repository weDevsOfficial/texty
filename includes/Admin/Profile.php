<?php

namespace Texty\Admin;

use WP_User;

/**
 * Profile Class
 */
class Profile {

    /**
     * Initialize
     */
    public function __construct() {
        add_filter( 'user_contactmethods', [ $this, 'add_contact_methods' ], 8, 2 );
    }

    /**
     * Add phone number as contact method
     *
     * @param array   $methods
     * @param WP_User $user
     *
     * @return array
     */
    public function add_contact_methods( $methods, $user ) {
        $methods['texty_phone'] = __( 'Phone Number (Texty)', 'texty' );

        return $methods;
    }
}

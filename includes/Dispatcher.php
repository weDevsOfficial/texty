<?php

namespace Texty;

/**
 * Dispatcher Class
 */
class Dispatcher {

    /**
     * Initialize
     */
    public function __construct() {
        add_action( 'user_register', [ $this, 'user_register' ] );
    }

    /**
     * Send message upon user registration
     *
     * @param int $user_id
     *
     * @return void
     */
    public function user_register( $user_id ) {
        $class    = texty()->notifications()->get( 'registration' );
        $notifier = new $class();
        $notifier->set_user( $user_id );

        $notifier->send();
    }
}

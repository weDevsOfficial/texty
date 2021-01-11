<?php

namespace Texty\Notifications;

class Registration extends Notification {

    /**
     * @var int
     */
    private $user_id;

    /**
     * Initialize
     */
    public function __construct() {
        $this->title = __( 'New User Registration' );
        $this->id    = 'registration';
    }

    /**
     * Set the user ID
     *
     * @param int $user_id
     *
     * @return self
     */
    public function set_user( $user_id ) {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Return the message
     *
     * @return string
     */
    public function get_message() {
        return __return_empty_string();
    }

    /**
     * Get replacement keys
     *
     * @return array
     */
    public function replacement_keys() {
        return [
            'user_id'      => 'ID',
            'username'     => 'user_login',
            'email'        => 'user_email',
            'display_name' => 'display_name',
            'first_name'   => 'first_name',
            'last_name'    => 'last_name',
        ];
    }

    /**
     * Return recipients
     *
     * @return array
     */
    public function get_recipients() {
        return __return_empty_array();
    }
}

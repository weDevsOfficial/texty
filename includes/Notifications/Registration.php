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
        $message = parent::get_message_raw();

        if ( ! $this->user_id ) {
            return $message;
        }

        $user = get_user_by( 'id', $this->user_id );

        foreach ( $this->replacement_keys() as $search => $value ) {
            $message = str_replace( '{' . $search . '}', $user->$value, $message );
        }

        return $message;
    }

    /**
     * Return recipients
     *
     * @return array
     */
    public function get_recipients() {
        return $this->get_numbers_by_roles();
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
}

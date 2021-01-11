<?php

namespace Texty\Notifications;

abstract class Notification {

    /**
     * Name of the notification
     *
     * @var string
     */
    protected $title;

    /**
     * The notification ID
     *
     * @var string
     */
    protected $id;

    /**
     * Type of the notification
     *
     * @var string
     */
    protected $type = 'role';

    /**
     * Notification group
     *
     * @var string
     */
    protected $group = 'wp';

    /**
     * Get the title
     *
     * @return string
     */
    public function get_title() {
        return $this->title;
    }

    /**
     * Get the ID
     *
     * @return string
     */
    public function get_id() {
        return $this->id;
    }

    /**
     * Type of the message
     *
     * @return string
     */
    public function get_type() {
        return $this->type;
    }

    /**
     * Type of the message
     *
     * @return string
     */
    public function get_group() {
        return $this->group;
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
        return __return_empty_array();
    }

    /**
     * Return recipients
     *
     * @return array
     */
    public function get_recipients() {
        return __return_empty_array();
    }

    /**
     * Check if the gateway is enabled
     *
     * @return bool
     */
    public function enabled() {
        return false;
    }

    /**
     * Send message to recipients
     *
     * @return void
     */
    public function send() {
        $recipients = $this->get_recipients();

        if ( $recipients ) {
            $content = $this->get_message();
            $gateway = texty()->gateways();

            foreach ( $recipients as $number ) {
                $gateway->send( $number, $content );
            }
        }
    }
}

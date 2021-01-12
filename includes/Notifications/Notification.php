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
    public function get_message_raw() {
        $settings = $this->settings();

        if ( isset( $settings['message'] ) ) {
            return $settings['message'];
        }

        return '';
    }

    /**
     * Return the message
     *
     * @return string
     */
    public function get_message() {
        return $this->get_message_raw();
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
    public function get_recipients_raw() {
        $settings = $this->settings();

        if ( isset( $settings['recipients'] ) ) {
            return $settings['recipients'];
        }

        return [];
    }

    /**
     * Return recipients
     *
     * @return array
     */
    public function get_recipients() {
        return $this->get_recipients_raw();
    }

    /**
     * Get phone numbers by roles
     *
     * @return array
     */
    protected function get_numbers_by_roles() {
        global $wpdb;

        $numbers = [];
        $roles   = $this->get_recipients_raw();

        if ( ! ( is_array( $roles ) && $roles ) ) {
            return false;
        }

        foreach ( $roles as $role ) {
            $users = get_users( [
                'role'       => $role,
                'fields'     => 'ID',
                'meta_query' => [
                    [
                        'key' => 'texty_phone',
                    ],
                ],
            ] );

            if ( ! $users ) {
                continue;
            }

            $results = $wpdb->get_col(
                sprintf( "SELECT `meta_value` from $wpdb->usermeta WHERE `user_id` IN (%s) AND `meta_key` = 'texty_phone'", implode( ', ', $users ) )
            );

            foreach ( $results as $number ) {
                $numbers[] = $number;
            }
        }

        return $numbers;
    }

    /**
     * Check if the gateway is enabled
     *
     * @return bool
     */
    public function enabled() {
        $settings = $this->settings();

        if ( isset( $settings['enabled'] ) && $settings['enabled'] === true ) {
            return true;
        }

        return false;
    }

    /**
     * Get the notification settings
     *
     * @return array
     */
    public function settings() {
        $settings = texty()->notifications()->settings();

        if ( isset( $settings[ $this->get_id() ] ) ) {
            return $settings[ $this->get_id() ];
        }

        return [];
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

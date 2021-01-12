<?php

namespace Texty;

/**
 * Notification Class
 */
class Notifications {

    /**
     * Option key to hold the notifications
     */
    const option_key = 'texty_notifications';

    /**
     * Notifications
     *
     * @var array
     */
    private $notifications = [];

    /**
     * Get a notification class
     *
     * @param string $key
     *
     * @return false|string
     */
    public function get( $key ) {
        $notifications = $this->all();

        if ( array_key_exists( $key, $notifications ) ) {
            return $notifications[ $key ];
        }

        return false;
    }

    /**
     * Get available notification classes
     *
     * @return array
     */
    public function all() {
        if ( $this->notifications ) {
            return $this->notifications;
        }

        $notifications = [
            'registration' => __NAMESPACE__ . '\Notifications\Registration',
            'comment'      => __NAMESPACE__ . '\Notifications\Comment',
        ];

        $this->notifications = apply_filters( 'texty_available_notifications', $notifications );

        return $this->notifications;
    }

    /**
     * Get the name of the groups
     *
     * @return void
     */
    public function get_groups() {
        return apply_filters( 'texty_notification_groups', [
            'wp' => [
                'title'       => __( 'WordPress', 'texty' ),
                'description' => '',
            ],
        ] );
    }

    /**
     * Retreive all the settings
     *
     * @return array
     */
    public function settings() {
        return get_option( self::option_key, [] );
    }
}

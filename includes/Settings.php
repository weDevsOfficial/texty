<?php

namespace Texty;

/**
 * Settings Class
 */
class Settings {

    /**
     * Option key to hold the settings
     */
    const option_key = 'texty_settings';

    /**
     * Return all the settings
     *
     * @return array
     */
    public function all() {
        $default = apply_filters( 'texty_settings_default', [
            'from'    => '',
            'gateway' => '',
            'twilio'  => [
                'sid'   => '',
                'token' => '',
            ],
            'vonage' => [
                'key'    => '',
                'secret' => '',
            ],
        ] );

        $settings = get_option( self::option_key, [] );

        return wp_parse_args( $settings, $default );
    }

    /**
     * Get a settings value by key
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get( $key ) {
        $settings = $this->all();

        if ( isset( $settings[ $key ] ) ) {
            return $settings[ $key ];
        }

        return false;
    }

    /**
     * Get the active gateway name
     *
     * @return string|false
     */
    public function gateway() {
        return $this->get( 'gateway' );
    }

    /**
     * Get the from number
     *
     * @return string|false
     */
    public function from() {
        return $this->get( 'from' );
    }
}

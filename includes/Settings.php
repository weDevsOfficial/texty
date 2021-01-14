<?php

namespace Texty;

/**
 * Settings Class
 */
class Settings {

    /**
     * Option key to hold the settings in database
     */
    const OPTION_KEY = 'texty_settings';

    /**
     * Return all the settings
     *
     * @return array
     */
    public function all() {
        $default = apply_filters( 'texty_settings_default', [ // phpcs:ignore
            'gateway' => '',
            'twilio'  => [
                'sid'   => '',
                'token' => '',
                'from'  => '',
            ],
            'vonage' => [
                'key'    => '',
                'secret' => '',
                'from'   => '',
            ],
        ] ); // phpcs:ignore

        $settings = get_option( self::OPTION_KEY, [] );

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
}

<?php

namespace Texty\Gateways;

use WP_Error;

/**
 * Nexmo Class
 *
 * @see https://developer.nexmo.com/api/sms
 */
class Nexmo implements GatewayInterface {

    /**
     * API Endpoint
     */
    const ENDPOINT = 'https://rest.nexmo.com/sms/json';

    /**
     * The API Key
     *
     * @var string
     */
    private $key;

    /**
     * API Secret
     *
     * @var string
     */
    private $secret;

    /**
     * Get the name
     *
     * @return string
     */
    public function name() {
        return __( 'Vonage (nexmo)', 'texty' );
    }

    /**
     * Set API key
     *
     * @param string $api_key
     *
     * @return void
     */
    public function set_key( $key ) {
        $this->key = $key;

        return $this;
    }

    /**
     * Set API secret
     *
     * @param string $secret
     *
     * @return void
     */
    public function set_secret( $secret ) {
        $this->$secret = $secret;

        return $this;
    }

    /**
     * Get the logo
     *
     * @return string
     */
    public function logo() {
        return TEXTY_URL . '/assets/images/vonage.svg';
    }

    /**
     * Get the credentials
     *
     * @return array
     */
    public function get_credential() {
        return [];
    }

    /**
     * Send SMS
     *
     * @param string $to
     * @param string $message
     *
     * @return WP_Error|bool
     */
    public function send( $to, $message, $from ) {
        $args = [
            'body' => [
                'from'       => $from,
                'api_key'    => $this->key,
                'api_secret' => $this->secret,
                'to'         => $to,
                'text'       => $message,
                'type'       => 'text',
            ],
        ];

        $request = wp_remote_post( self::ENDPOINT, $args );

        if ( is_wp_error( $request ) ) {
            return $request;
        }

        return true;
    }
}

<?php

namespace Textly\Gateways;

use Textly\Interfaces\Gateway;
use WP_Error;

/**
 * Nexmo Class
 *
 * @see https://developer.nexmo.com/api/sms
 */
class Nexmo implements Gateway {

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
     * [__construct description]
     *
     * @param string $key
     * @param string $secret
     */
    public function __construct( $key, $secret ) {
        $this->key    = $key;
        $this->secret = $secret;
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

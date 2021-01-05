<?php

namespace Textly\Gateways;

use Textly\Interfaces\Gateway;
use WP_Error;

/**
 * Clickatell Class
 *
 * @see https://www.clickatell.com/developers/api-documentation/rest-api-send-message/
 */
class Clickatell implements Gateway {

    /**
     * API Endpoint
     */
    const ENDPOINT = 'https://platform.clickatell.com/messages';

    /**
     * The API Key
     *
     * @var string
     */
    private $api_key;

    /**
     * [__construct description]
     *
     * @param string $api_key
     */
    public function __construct( $api_key ) {
        $this->api_key = $api_key;
    }

    /**
     * Send SMS
     *
     * @param string $to
     * @param string $message
     *
     * @return WP_Error|true
     */
    public function send( $to, $message, $from ) {
        $args = [
            'headers' => [
                'Authorization' => $this->api_key,
            ],
            'body' => wp_json_encode(
                [
                    'from'    => $from,
                    'to'      => [ $to ],
                    'content' => $message,
                ]
            ),
        ];

        $response = wp_remote_post( self::ENDPOINT, $args );

        return true;
    }
}

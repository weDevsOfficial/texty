<?php

namespace Texty\Gateways;

use WP_Error;

/**
 * Clickatell Class
 *
 * @see https://www.clickatell.com/developers/api-documentation/rest-api-send-message/
 */
class Clickatell implements GatewayInterface {

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
     * Set API key
     *
     * @param string $api_key
     *
     * @return void
     */
    public function set_api_key( $api_key ) {
        $this->api_key = $api_key;

        return $this;
    }

    /**
     * Get the name
     *
     * @return string
     */
    public function name() {
        return __( 'Clickatell', 'texty' );
    }

    /**
     * Get the logo
     *
     * @return string
     */
    public function logo() {
        return TEXTY_URL . '/assets/images/clickatell.svg';
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
     * @return WP_Error|true
     */
    public function send( $to, $message ) {
        $args = [
            'headers' => [
                'Authorization' => $this->api_key,
            ],
            'body' => wp_json_encode(
                [
                    'from'    => texty()->settings()->from(),
                    'to'      => [ $to ],
                    'content' => $message,
                ]
            ),
        ];

        $response = wp_remote_post( self::ENDPOINT, $args );

        return true;
    }

    /**
     * Validate a REST API request
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|true
     */
    public function validate( $request ) {
        $creds = $request->get_param( 'twilio' );
    }
}

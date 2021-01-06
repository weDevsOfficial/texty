<?php

namespace Texty\Gateways;

use WP_Error;

/**
 * Twilio Class
 *
 * @see https://www.twilio.com/docs/sms/api/message
 */
class Twilio implements GatewayInterface {

    /**
     * API Endpoint
     */
    const ENDPOINT = 'https://api.twilio.com/2010-04-01/Accounts/{sid}/Messages.json';

    /**
     * The Account SID
     *
     * @var string
     */
    private $sid;

    /**
     * Account Auth Token
     *
     * @var string
     */
    private $token;

    /**
     * Get the name
     *
     * @return string
     */
    public function name() {
        return __( 'Twilio', 'texty' );
    }

    /**
     * Set Account SID
     *
     * @param string $sid
     *
     * @return void
     */
    public function set_sid( $sid ) {
        $this->sid = $sid;

        return $this;
    }

    /**
     * Set API token
     *
     * @param string $token
     *
     * @return void
     */
    public function set_token( $token ) {
        $this->$token = $token;

        return $this;
    }

    /**
     * Get the logo
     *
     * @return string
     */
    public function logo() {
        return TEXTY_URL . '/assets/images/twilio.svg';
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
    public function send( $to, $message, $from ) {
        $args = [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode( $this->sid . ':' . $this->token ), // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode
            ],
            'body' => [
                'From' => $from,
                'To'   => $to,
                'Body' => $message,
            ],
        ];

        $endpoint = str_replace( '{sid}', $this->sid, self::ENDPOINT );
        $response = wp_remote_post( $endpoint, $args );
        $body     = json_decode( wp_remote_retrieve_body( $response ) );

        if ( 201 !== $response['response']['code'] ) {
            return new WP_Error( $body->code, $body->message );
        }

        return true;
    }
}

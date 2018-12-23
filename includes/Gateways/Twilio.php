<?php
namespace Textly\Gateways;

use Textly\Interfaces\Gateway;

/**
 * Twilio Class
 *
 * @see https://www.twilio.com/docs/sms/api/message
 */
class Twilio implements Gateway {

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
     * [__construct description]
     *
     * @param string $sid
     * @param string $token
     */
    function __construct( $sid, $token ) {
        $this->sid    = $sid;
        $this->token = $token;
    }

    /**
     * Send SMS
     *
     * @param  string $to
     * @param  string $message
     *
     * @return \WP_Error|true
     */
    public function send( $to, $message, $from ) {
        $args = [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode( $this->sid . ':' . $this->token )
            ],
            'body' => [
                'From' => $from,
                'To'   => $to,
                'Body' => $message
            ]
        ];

        $endpoint = str_replace( '{sid}', $this->sid, self::ENDPOINT );
        $response = wp_remote_post( $endpoint, $args );
        $body     = json_decode( wp_remote_retrieve_body( $response ) );

        if ( 201 !== $response['response']['code'] ) {
            return new \WP_Error( $body->code, $body->message );
        }

        return true;
    }

}

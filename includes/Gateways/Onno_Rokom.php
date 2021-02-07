<?php

namespace Texty\Gateways;

use WP_Error;

/**
 * Onno_Rokom Class
 *
 * @see https://panel.onnorokomsms.com/Content/OnnoRokomSmsWebSeviceAndApiDocumentation.pdf
 * @see https://www.onnorokomsms.com/Features/DeveloperApi
 */
class Onno_Rokom implements GatewayInterface {

    /**
     * API Endpoint
     */
    const ENDPOINT = 'https://api2.onnorokomsms.com/HttpSendSms.ashx';

    /**
     * Get the name
     *
     * @return string
     */
    public function name() {
        return __( 'Onno Rokom SMS', 'texty' );
    }

    /**
     * Get the name
     *
     * @return string
     */
    public function description() {
        return sprintf(
            __(
                'Send SMS with Onno Rokom SMS Service. Follow <a href="%1$s" target="_blank">this link</a> to get the API key.',
                'texty'
            ),
            'https://panel.onnorokomsms.com/Client/Client/ChangeApiToken'
        );
    }

    /**
     * Get the logo
     *
     * @return string
     */
    public function logo() {
        return TEXTY_URL . '/assets/images/onnorokom.png';
    }

    /**
     * Get the settings
     *
     * @return array
     */
    public function get_settings() {
        $creds = texty()->settings()->get( 'onno_rokom' );

        return [
            'api_key' => [
                'name'  => __( 'API Key', 'texty' ),
                'type'  => 'password',
                'value' => isset( $creds['api_key'] ) ? $creds['api_key'] : '',
                'help'  => '',
            ],
            'mask_name' => [
                'name'  => __( 'Mask Name', 'texty' ),
                'type'  => 'text',
                'value' => isset( $creds['mask_name'] ) ? $creds['mask_name'] : '',
                'help'  => __( 'Mask Name which is allowed to your client panel', 'texty' ),
            ],
        ];
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
        $creds = texty()->settings()->get( 'onno_rokom' );

        $args = [
            'body' => [
                'op'                        => 'NumberSms',
                'apiKey'                    => $creds['api_key'],
                'type'                      => 'TEXT',
                'mobile'                    => $to,
                'smsText'                   => $message,
                'maskName'                  => $creds['mask_name'],
                'campaignName'              => '',
            ],
        ];

        $response = wp_remote_post( self::ENDPOINT, $args );

        if ( is_wp_error( $response ) ) {
            return $response;
        }

        $body = wp_remote_retrieve_body( $response );

        if ( $error = $this->parseResponseForError( $body ) ) {
            return new WP_Error(
                $error['code'],
                $error['message']
            );
        }

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
        $creds = $request->get_param( 'onno_rokom' );

        return [
            'api_key'    => $creds['api_key'],
        ];
    }

    /**
     * Parse the response for error code and message.
     * If the $resp is success response then return null
     *
     * @param string $resp
     *
     * @return array|null
     */
    protected function parseResponseForError( $resp ) {
        $errors = [
            '1901' => 'Parameter content missing',
            '1902' => 'Invalid user/pass',
            '1903' => 'Not enough balance',
            '1905' => 'Invalid destination number',
            '1906' => 'Operator Not found',
            '1907' => 'Invalid mask Name',
            '1908' => 'Sms body too long',
            '1909' => 'Duplicate campaign Name',
            '1910' => 'Invalid message',
            '1911' => 'Too many Sms Request Please try less then 10000 in one request',
        ];

        foreach ( $errors as $code => $msg ) {
            if ( strpos( $resp, "$code||" ) !== false ) {
                return [
                    'code'    => $code,
                    'message' => $msg,
                ];
            }
        }

        return null;
    }
}

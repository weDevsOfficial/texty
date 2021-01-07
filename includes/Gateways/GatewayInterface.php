<?php

namespace Texty\Gateways;

interface GatewayInterface {

    /**
     * Send a text
     *
     * @param string $to
     * @param string $message
     *
     * @return void
     */
    public function send( $to, $message );

    /**
     * Returns URL to the logo
     *
     * @return string
     */
    public function logo();

    /**
     * Get the gateway name
     *
     * @return string
     */
    public function name();

    /**
     * Get gateway credential
     *
     * @return array
     */
    public function get_credential();

    /**
     * Validate a REST API request
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|true
     */
    public function validate( $request );
}

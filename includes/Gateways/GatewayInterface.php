<?php

namespace Texty\Gateways;

interface GatewayInterface {

    /**
     * Send a text
     *
     * @param string $to
     * @param string $message
     * @param string $from
     *
     * @return void
     */
    public function send( $to, $message, $from );

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
}

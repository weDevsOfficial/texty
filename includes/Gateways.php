<?php

namespace Texty;

use WP_Error;

/**
 * Manager Class
 */
class Gateways {

    /**
     * Send the message from the active gateway
     *
     * @param string $to      The TO phone number
     * @param string $message The message to send
     * @param string $from    The From address
     *
     * @return bool|WP_Error
     */
    public function send( $to, $message, $from ) {
        return $this->active_gateway()->send( $to, $message, $from );
    }

    /**
     * Get the active gateway
     *
     * @return Interfaces\Gateway
     */
    public function active_gateway() {
        $gateways = $this->all();
        $active   = get_option( 'textly_options', [] );

        return new $active();
    }

    /**
     * Get all the available gateways
     *
     * @return array
     */
    public function all() {
        $gateways = [
            'twilio'     => __NAMESPACE__ . '\Gateways\Twilio',
            'nexmo'      => __NAMESPACE__ . '\Gateways\Nexmo',
            'clickatell' => __NAMESPACE__ . '\Gateways\Clickatell',
        ];

        return apply_filters( 'textly_available_gateways', $gateways );
    }
}

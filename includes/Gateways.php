<?php
namespace WeDevs\Textly;

/**
 * Manager Class
 */
class Gateways {

    /**
     * Send the message from the active gateway
     *
     * @param  string $to      The TO phone number
     * @param  string $message The message to send
     * @param  string $from    The From address
     *
     * @return boolean|\WP_Error
     */
    public function send( $to, $message, $from ) {
        return $this->active_gateway()->send( $to, $message, $from );
    }

    public function active_gateway() {
        $gateways = $this->all();
        $active   = get_option( 'textly_options', [] );

        return new $active;
    }

    /**
     * Get all the available gateways
     *
     * @return array
     */
    public function all() {
        $gateways = [
            'twilio' => __NAMESPACE__ . '\Gateway\Twilio',
            'nexmo'  => __NAMESPACE__ . '\Gateway\Nexmo',
        ];

        return apply_filters( 'available_gateways', $gateways );
    }

}

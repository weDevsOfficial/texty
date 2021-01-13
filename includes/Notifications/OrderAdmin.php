<?php

namespace Texty\Notifications;

class OrderAdmin extends Notification {

    /**
     * @var object
     */
    private $order;

    /**
     * Initialize
     */
    public function __construct() {
        $this->title              = __( 'New Order (admin)', 'texty' );
        $this->id                 = 'order_admin';
        $this->group              = 'wc';
        $this->default_recipients = ['administrator'];

        $this->default = <<<'EOD'
New order received #{order_id}, paid via {payment_method}.

Customer: {customer_name} ({customer_email})
Status: {status}
Order Total: {order_total}
EOD;
    }

    /**
     * Set the user ID
     *
     * @param int $order_id
     *
     * @return self
     */
    public function set_order( $order ) {
        $this->order = $order;

        return $this;
    }

    /**
     * Return the message
     *
     * @return string
     */
    public function get_message() {
        $message = parent::get_message_raw();

        if ( ! $this->order ) {
            return $message;
        }

        foreach ( $this->replacement_keys() as $search => $method ) {
            $value = method_exists( $this->order, $method ) ? $this->order->$method() : '';

            if ( 'customer_name' === $search ) {
                $value = $this->order->get_user()->display_name;
            }

            if ( 'order_total' === $search ) {
                $value = strip_tags( html_entity_decode( $value ) );
            }

            $message = str_replace( '{' . $search . '}', $value, $message );
        }

        return $message;
    }

    /**
     * Return recipients
     *
     * @return array
     */
    public function get_recipients() {
        return $this->get_numbers_by_roles();
    }

    /**
     * Get replacement keys
     *
     * @return array
     */
    public function replacement_keys() {
        return [
            'order_id'        => 'get_id',
            'date'            => 'get_date_paid',
            'status'          => 'get_status',
            'payment_method'  => 'get_payment_method_title',
            'shipping_method' => 'get_shipping_method',
            'transaction_id'  => 'get_transaction_id',
            'customer_name'   => 'customer_name',
            'customer_email'  => 'get_billing_email',
            'order_total'     => 'get_formatted_order_total',
            'shipping_total'  => 'get_shipping_total',
            'tax_total'       => 'get_total_tax',
        ];
    }
}

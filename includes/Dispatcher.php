<?php

namespace Texty;

/**
 * Dispatcher Class
 */
class Dispatcher {

    /**
     * Initialize
     */
    public function __construct() {

        // WordPress Events
        add_action( 'user_register', [ $this, 'user_register' ] );
        add_action( 'comment_post', [ $this, 'new_comment' ] );

        // WooCommerce Events
        add_action( 'woocommerce_order_status_changed', [ $this, 'order_status_changed' ], 10, 4 );
    }

    /**
     * Send message upon user registration
     *
     * @param int $user_id
     *
     * @return void
     */
    public function user_register( $user_id ) {
        $class    = texty()->notifications()->get( 'registration' );
        $notifier = new $class();

        if ( ! $notifier->enabled() ) {
            return;
        }

        $notifier->set_user( $user_id );

        $notifier->send();
    }

    /**
     * Send message upon a new comment
     *
     * @param int $comment_id
     *
     * @return void
     */
    public function new_comment( $comment_id ) {
        $class    = texty()->notifications()->get( 'comment' );
        $notifier = new $class();

        if ( ! $notifier->enabled() ) {
            return;
        }

        $notifier->set_comment( $comment_id );
        $notifier->send();
    }

    /**
     * Send a message when an order status changes
     *
     * @param int      $order_id
     * @param string   $from
     * @param string   $to
     * @param WC_Order $order
     *
     * @return void
     */
    public function order_status_changed( $order_id, $from, $to, $order ) {
        $new_statuses = [ 'processing', 'completed' ];

        if ( in_array( $to, $new_statuses ) ) {
            $class       = texty()->notifications()->get( 'order_admin' );
            $order_admin = new $class();

            // if enabled and we haven't sent it already
            if ( $order_admin->enabled() ) {
                $has_sent = $order->get_meta( '_texty_order_admin', true );

                if ( ! $has_sent ) {
                    $order_admin->set_order( $order );
                    $order_admin->send();

                    $order->add_meta_data( '_texty_order_admin', 1 );
                    $order->save_meta_data();
                }
            }
        }
    }
}

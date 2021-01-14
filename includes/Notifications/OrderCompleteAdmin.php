<?php

namespace Texty\Notifications;

class OrderCompleteAdmin extends OrderBase {

    /**
     * Initialize
     */
    public function __construct() {
        $this->title              = __( 'Admin - When Order Status is Complete', 'texty' );
        $this->id                 = 'order_admin_complete';
        $this->group              = 'wc';
        $this->default_recipients = [ 'administrator' ];

        $this->default = <<<'EOD'
New order received #{order_id}, paid via {payment_method}.

Customer: {billing_name} ({billing_email})
Status: {status}
Order Total: {order_total}
EOD;
    }
}

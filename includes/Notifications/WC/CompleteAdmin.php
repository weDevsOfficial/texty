<?php

namespace Texty\Notifications\WC;

class CompleteAdmin extends Base {

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

{items}

Customer: {billing_name} ({billing_email})
Status: {status}
Order Total: {order_total}
EOD;
    }
}

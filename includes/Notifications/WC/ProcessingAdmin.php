<?php

namespace Texty\Notifications\WC;

class ProcessingAdmin extends Base {

    /**
     * Initialize
     */
    public function __construct() {
        $this->title              = __( 'Admin - When Order Status is Processing', 'texty' );
        $this->id                 = 'order_admin_processing';
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

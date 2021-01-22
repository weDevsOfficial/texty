<?php

namespace Texty\Notifications\WC;

class HoldCustomer extends Base {

    /**
     * Initialize
     */
    public function __construct() {
        $this->title = __( 'Customer - When Order Status is On Hold', 'texty' );
        $this->id    = 'order_customer_hold';
        $this->group = 'wc';
        $this->type  = 'user';

        $this->default = <<<'EOD'
Hello {billing_name}, your order #{order_id} with {site_name} has been put on hold, our team will contact your shortly with more details.

{site_url}
EOD;
    }
}

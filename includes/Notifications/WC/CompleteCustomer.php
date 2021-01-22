<?php

namespace Texty\Notifications\WC;

class CompleteCustomer extends Base {

    /**
     * Initialize
     */
    public function __construct() {
        $this->title = __( 'Customer - When Order Status is Complete', 'texty' );
        $this->id    = 'order_customer_complete';
        $this->group = 'wc';
        $this->type  = 'user';

        $this->default = <<<'EOD'
Hello {billing_name}, your order #{order_id} with {site_name} has been completed.

Thanks for being with us.
{site_url}
EOD;
    }
}

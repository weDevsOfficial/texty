<?php

namespace Texty\Notifications\WC;

class ProcessingCustomer extends Base {

    /**
     * Initialize
     */
    public function __construct() {
        $this->title = __( 'Customer - When Order Status is Processing', 'texty' );
        $this->id    = 'order_customer_processing';
        $this->group = 'wc';
        $this->type  = 'user';

        $this->default = <<<'EOD'
Hello {billing_name}, thank you for placing your order #{order_id} with {site_name}.

{site_url}
EOD;
    }
}

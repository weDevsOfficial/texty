<?php

namespace Texty\Notifications\Dokan;

use Texty\Notifications\WC\Base as OrderBase;

class Base extends OrderBase {

    /**
     * Vendor ID
     *
     * @var int
     */
    protected $vendor_id;

    /**
     * Set vendor ID
     *
     * @param int $vendor_id
     *
     * @return void
     */
    public function set_vendor( $vendor_id ) {
        $this->vendor_id = $vendor_id;
    }

    /**
     * Return recipients
     *
     * @return array
     */
    public function get_recipients() {
        if ( ! $this->vendor_id ) {
            return [];
        }

        $vendor = dokan()->vendor->get( $this->vendor_id );
        $phone  = $vendor->get_phone();

        return $phone ? [ $phone ] : [];
    }
}

<?php
namespace WeDevs\Textly\Gateway;

interface Contract {

    public function send( $to, $message, $from );
    // public function get_balance();
}

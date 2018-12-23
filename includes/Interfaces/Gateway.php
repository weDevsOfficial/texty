<?php
namespace Textly\Interfaces;

interface Contract {

    public function send( $to, $message, $from );
    // public function get_balance();
}

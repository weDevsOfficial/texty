<?php

namespace Textly\Interfaces;

interface Gateway {

    /**
     * Send a text
     *
     * @param string $to
     * @param string $message
     * @param string $from
     *
     * @return void
     */
    public function send( $to, $message, $from );
}

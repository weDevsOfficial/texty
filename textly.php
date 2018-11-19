<?php
/**
 * Plugin Name: Textly - SMS Plugin for WordPress
 * Description: Send SMS to users
 * Plugin URI: https://textly.com
 * Author: weDevs
 * Author URI: https://tareq.co
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: textly
 */

defined( 'ABSPATH' ) or exit;

require __DIR__ . '/vendor/autoload.php';

/**
 * Textly Class
 */
class Textly {

    function __construct() {
        # code...
    }

    /**
     * Initializes the Textly class
     *
     * Checks for an existing Textly instance
     * and if it doesn't find one, creates it.
     */
    public static function instance() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Access to gateway manager
     *
     * @return \WeDevs\Textly\Gateways
     */
    public function gateway() {
        return new \WeDevs\Textly\Gateways();
    }
}

/**
 * Return the instance
 *
 * @return \Textly
 */
function textly() {
    return Textly::instance();
}

// take off
textly();

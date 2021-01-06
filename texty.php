<?php
/**
 * Plugin Name: Texty - SMS Plugin for WordPress
 * Description: Send SMS to users
 * Plugin URI: https://textywp.com
 * Author: weDevs
 * Author URI: https://tareq.co
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: texty
 */

use PHP_CodeSniffer\Generators\Text;

defined( 'ABSPATH' ) || exit;

require __DIR__ . '/vendor/autoload.php';

/**
 * Textly Class
 */
class Texty {

    /**
     * Initialize
     */
    public function __construct() {
        $this->define_constants();

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
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
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {
        if ( is_admin() ) {
            new Texty\Admin();
        }

        new Texty\Api();
    }

    /**
     * Define constants
     *
     * @return void
     */
    private function define_constants() {
        define( 'TEXTY_DIR', __DIR__ );
        define( 'TEXTY_FILE', __FILE__ );
        define( 'TEXTY_URL', plugins_url( '', __FILE__ ) );
    }

    /**
     * Access to gateway manager
     *
     * @return \WeDevs\Texty\Gateways
     */
    public function gateway() {
        return new \Texty\Gateways();
    }
}

/**
 * Return the instance
 *
 * @return \Textly
 */
function texty() {
    return Texty::instance();
}

// take off
texty();

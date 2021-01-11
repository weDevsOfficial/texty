<?php
/**
 * Plugin Name: Texty
 * Description: SMS Notification for WordPress
 * Plugin URI: https://github.com/weDevsOfficial/texty
 * Author: weDevs
 * Author URI: https://tareq.co
 * Version: 0.1
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: texty
 */
defined( 'ABSPATH' ) || exit;

require __DIR__ . '/vendor/autoload.php';

/**
 * Textly Class
 */
final class Texty {

    /**
     * Instances array
     *
     * @var array
     */
    private $instances = [];

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
     * @return Texty\Gateways
     */
    public function gateways() {
        if ( ! isset( $this->instances['gateway'] ) ) {
            $this->instances['gateway'] = new \Texty\Gateways();
        }

        return $this->instances['gateway'];
    }

    /**
     * Access to gateway manager
     *
     * @return Texty\Settings
     */
    public function settings() {
        if ( ! isset( $this->instances['settings'] ) ) {
            $this->instances['settings'] = new \Texty\Settings();
        }

        return $this->instances['settings'];
    }

    /**
     * Access to gateway manager
     *
     * @return Texty\Notifications
     */
    public function notifications() {
        if ( ! isset( $this->instances['notification'] ) ) {
            $this->instances['notification'] = new \Texty\Notifications();
        }

        return $this->instances['notification'];
    }
}

/**
 * Return the instance
 *
 * @return \Texty
 */
function texty() {
    return Texty::instance();
}

// take off
texty();

<?php

namespace Textly;

/**
 * Manager Class
 */
class Admin {

    /**
     * Initialize
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'register_menu' ] );
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function register_menu() {
        $menu = add_menu_page(
            __( 'Textly', 'textly' ),
            __( 'Textly', 'textly' ),
            'manage_options',
            'textly',
            [ $this, 'render_page' ],
            'dashicons-format-chat',
            57
        );

        add_action( 'admin_print_scripts-' . $menu, [ $this, 'enqueue_scripts' ] );
    }

    /**
     * Render the page
     *
     * @return void
     */
    public function render_page() {
        echo '<div id="textly-app"></div>';
    }

    /**
     * Enqueue JS and CSS
     *
     * @return void
     */
    public function enqueue_scripts() {
        $assets = require TEXTLY_DIR . '/dist/admin.asset.php';

        $url = TEXTLY_URL;

        // for local development
        // when webpack "hot module replacement" is enabled, this
        // constant needs to be turned "true" on "wp-config.php"
        if ( defined( 'WP_LOCAL_DEV' ) && WP_LOCAL_DEV ) {
            $url = str_replace( '.test', '.test:8080', $url );
        }

        // register scripts
        wp_register_script( 'textly-vendors', $url . '/dist/vendors.js', $assets['dependencies'], $assets['version'], true );
        wp_register_script( 'textly-admin', $url . '/dist/admin.js', [ 'textly-vendors' ], $assets['version'], true );

        // register styles
        wp_register_style( 'textly-vendors-css', $url . '/dist/vendors.css', [ 'wp-components' ], $assets['version'] );
        wp_register_style( 'textly-admin-css', $url . '/dist/style-admin.css', [  'textly-vendors-css' ], $assets['version'] );

        // enqueue scripts and styles
        wp_enqueue_script( 'textly-admin' );
        wp_enqueue_style( 'textly-admin-css' );
    }
}

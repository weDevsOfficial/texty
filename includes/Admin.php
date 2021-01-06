<?php

namespace Texty;

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
            __( 'Texty', 'texty' ),
            __( 'Texty', 'texty' ),
            'manage_options',
            'texty',
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
        $assets = require TEXTY_DIR . '/dist/admin.asset.php';

        $url = TEXTY_URL;

        // for local development
        // when webpack "hot module replacement" is enabled, this
        // constant needs to be turned "true" on "wp-config.php"
        if ( defined( 'WP_LOCAL_DEV' ) && WP_LOCAL_DEV ) {
            $url = str_replace( '.test', '.test:8080', $url );
        }

        // register scripts
        wp_register_script( 'texty-vendors', $url . '/dist/vendors.js', $assets['dependencies'], $assets['version'], true );
        wp_register_script( 'texty-admin', $url . '/dist/admin.js', [ 'texty-vendors' ], $assets['version'], true );
        wp_localize_script( 'texty-admin', 'texty', $this->localize_script() );

        // register styles
        wp_register_style( 'texty-vendors-css', $url . '/dist/vendors.css', [ 'wp-components' ], $assets['version'] );
        wp_register_style( 'texty-admin-css', $url . '/dist/style-admin.css', [ 'texty-vendors-css' ], $assets['version'] );

        // enqueue scripts and styles
        wp_enqueue_script( 'texty-admin' );
        wp_enqueue_style( 'texty-admin-css' );
    }

    /**
     * Get the localize script
     *
     * @return array
     */
    public function localize_script() {
        $i18n = [
            'gateways' => array_map( function ( $item ) { // phpcs:ignore PEAR.Functions.FunctionCallSignature.ContentAfterOpenBracket
                $obj = new $item();

                return [
                    'name'       => $obj->name(),
                    'logo'       => $obj->logo(),
                    'credential' => $obj->get_credential(),
                ];
            }, texty()->gateway()->all() ), // phpcs:ignore PEAR.Functions.FunctionCallSignature.CloseBracketLine
        ];

        return apply_filters( 'textly_localize_script', $i18n );
    }
}

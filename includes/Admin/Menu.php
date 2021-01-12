<?php

namespace Texty\Admin;

/**
 * Menu Class
 */
class Menu {

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
        $position = apply_filters( 'text_menu_position', 58 );

        $menu = add_menu_page(
            __( 'Texty', 'texty' ),
            __( 'Texty', 'texty' ),
            'manage_options',
            'texty',
            [ $this, 'render_page' ],
            'dashicons-format-chat',
            $position
        );

        add_action( 'admin_print_scripts-' . $menu, [ $this, 'enqueue_scripts' ] );
    }

    /**
     * Render the page
     *
     * @return void
     */
    public function render_page() {
        echo '<div id="texty-app"></div>';
    }

    /**
     * Enqueue JS and CSS
     *
     * @return void
     */
    public function enqueue_scripts() {
        $assets = [
            'version'      => time(),
            'dependencies' => [
                // 'wp-polyfill',
                'wp-api-fetch',
                'wp-i18n',
            ],
        ];

        $url = TEXTY_URL . '/dist';

        // for local development
        // when webpack "hot module replacement" is enabled, this
        // constant needs to be turned "true" on "wp-config.php"
        if ( defined( 'WP_LOCAL_DEV' ) && WP_LOCAL_DEV ) {
            $url = 'http://localhost:8080';
        }

        // register scripts
        wp_register_script( 'texty-runtime', $url . '/runtime.js', $assets['dependencies'], $assets['version'], true );
        wp_register_script( 'texty-vendors', $url . '/vendors.js', ['texty-runtime'], $assets['version'], true );
        wp_register_script( 'texty-admin', $url . '/app.js', [ 'texty-vendors' ], $assets['version'], true );
        wp_localize_script( 'texty-admin', 'texty', $this->localize_script() );

        // register styles
        wp_register_style( 'texty-vendors-css', $url . '/vendors.css', ['wp-components'], $assets['version'] );
        wp_register_style( 'texty-css', $url . '/app.css', [ 'texty-vendors-css' ], $assets['version'] );

        // enqueue scripts and styles
        wp_enqueue_script( 'texty-admin' );
        wp_enqueue_style( 'texty-css' );
    }

    /**
     * Get the localize script
     *
     * @return array
     */
    public function localize_script() {
        $i18n = [
        ];

        return apply_filters( 'textly_localize_script', $i18n );
    }
}

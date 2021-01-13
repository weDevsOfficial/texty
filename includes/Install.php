<?php

namespace Texty;

/**
 * Installer Class
 */
class Install {

    /**
     * Run the isntaller
     */
    public function run() {
        $installed = get_option( 'texty_installed' );

        if ( ! $installed ) {
            update_option( 'texty_installed', time() );
        }

        update_option( 'texty_version', TEXTY_VERSION );
    }
}

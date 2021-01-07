<?php

namespace Texty\Api;

use WP_REST_Server;

class Status extends Base {

    /**
     * Initialize
     *
     * @return void
     */
    public function __construct() {
        $this->namespace = 'texty/v1';
        $this->rest_base = 'status';
    }

    /**
     * Registers the routes for the objects of the controller.
     *
     * @return void
     */
    public function register_routes() {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            [
                [
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'status' ],
                    'permission_callback' => [ $this, 'admin_permissions_check' ],
                    'args'                => [],
                ],
            ]
        );
    }

    /*
     * Send a test.
     *
     * @param WP_Rest_Request $request
     *
     * @return WP_Rest_Response|WP_Error
     */
    public function status( $request ) {
        $gateway = texty()->settings()->gateway();

        $response = [
            'success' => $gateway ? true : false,
        ];

        return rest_ensure_response( $response );
    }
}

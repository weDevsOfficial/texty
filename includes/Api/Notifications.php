<?php

namespace Texty\Api;

use WP_REST_Server;

class Notifications extends Base {

    /**
     * Initialize
     *
     * @return void
     */
    public function __construct() {
        $this->namespace = 'texty/v1';
        $this->rest_base = 'notifications';
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
                    'callback'            => [ $this, 'get_items' ],
                    'permission_callback' => [ $this, 'admin_permissions_check' ],
                    'args'                => [],
                ],
                [
                    'methods'             => WP_REST_Server::EDITABLE,
                    'callback'            => [ $this, 'update_items' ],
                    'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::EDITABLE ),
                    'permission_callback' => [ $this, 'admin_permissions_check' ],
                ],
                'schema' => [ $this, 'get_item_schema' ],
            ]
        );
    }

    /**
     * Retrieves a list of items.
     *
     * @param WP_Rest_Request $request
     *
     * @return WP_Rest_Response|WP_Error
     */
    public function get_items( $request ) {
        if ( isset( $request['context'] ) && $request['context'] == 'edit' ) {
            $notifications = texty()->notifications()->all();

            $response = [
                'groups'        => texty()->notifications()->get_groups(),
                'notifications' => array_map( function ( $notifier ) {
                    $obj = new $notifier();

                    return [
                        'id'           => $obj->get_id(),
                        'enabled'      => $obj->enabled(),
                        'title'        => $obj->get_title(),
                        'type'         => $obj->get_type(),
                        'message'      => $obj->get_message(),
                        'group'        => $obj->get_group(),
                        'recipients'   => $obj->get_recipients(),
                        'replacements' => array_keys( $obj->replacement_keys() ),
                    ];
                }, $notifications ),
            ];
        } else {
            $response = texty()->notifications()->settings();
        }

        return rest_ensure_response( $response );
    }

    /**
     * Updates item from the collection.
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function update_items( $request ) {
    }
}

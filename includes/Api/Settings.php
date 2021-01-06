<?php

namespace Texty\Api;

use WP_REST_Controller;
use WP_REST_Server;

class Settings extends WP_REST_Controller {

    /**
     * Initialize
     *
     * @return void
     */
    public function __construct() {
        $this->namespace = 'texty/v1';
        $this->rest_base = 'settings';
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
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
                    'args'                => [],
                ],
                [
                    'methods'             => WP_REST_Server::EDITABLE,
                    'callback'            => [ $this, 'update_items' ],
                    'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::EDITABLE ),
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
                ],
                'schema' => [ $this, 'get_item_schema' ],
            ]
        );
    }

    /**
     * Permission check
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|bool
     */
    public function get_items_permissions_check( $request ) {
        return current_user_can( 'manage_options' );
    }

    /**
     * Retrieves a list of items.
     *
     * @param WP_Rest_Request $request
     *
     * @return WP_Rest_Response|WP_Error
     */
    public function get_items( $request ) {
        return [];
    }

    /**
     * Updates item from the collection.
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function update_items( $request ) {
        return [];
    }

    /**
     * Get registered items
     *
     * @return array
     */
    public function get_registered_items() {
        return [
            'gateway' => [
                'description' => __( 'The selected gateway', 'texty' ),
                'type'        => 'string',
                'context'     => [ 'edit' ],
            ],
        ];
    }

    /**
     * Retrieves the settings schema, conforming to JSON Schema.
     *
     * @return array
     */
    public function get_item_schema() {
        if ( $this->schema ) {
            return $this->add_additional_fields_schema( $this->schema );
        }

        $schema = [
            '$schema'    => 'http://json-schema.org/draft-04/schema#',
            'title'      => 'settings',
            'type'       => 'object',
            'properties' => [],
        ];

        foreach ( $this->get_registered_items() as $option => $args ) {
            $schema['properties'][ $option ] = $args;
        }

        $this->schema = $schema;

        return $this->add_additional_fields_schema( $this->schema );
    }
}

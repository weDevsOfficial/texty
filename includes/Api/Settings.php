<?php

namespace Texty\Api;

use Texty\Settings as TextySettings;
use WP_REST_Server;

class Settings extends Base {

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
            $settings = texty()->settings()->all();
            $gateways = texty()->gateway()->all();

            $response = [
                'gateway'  => $settings['gateway'],
                'gateways' => array_map( function ( $gateway ) {
                    $obj = new $gateway();

                    return [
                        'name'        => $obj->name(),
                        'logo'        => $obj->logo(),
                        'description' => $obj->description(),
                    ];
                }, $gateways ),
            ];

            foreach ( $gateways as $key => $gateway ) {
                $response[ $key ] = (new $gateway())->get_settings();
            }
        } else {
            $response = texty()->settings()->all();
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
        $settings   = texty()->settings()->all();
        $gateway    = $request->get_param( 'gateway' );
        $registered = texty()->gateway()->all();

        $value = [
            'gateway' => $gateway,
        ];

        // create a new gateway instance
        $object   = new $registered[ $gateway ]();
        $response = $object->validate( $request );

        if ( is_wp_error( $response ) ) {
            return $response;
        }

        // set the credentials with the gateway key
        $value[$gateway] = $response;

        $settings = array_merge( $settings, $value );

        update_option( TextySettings::option_key, $settings, false );

        $request->set_param( 'context', 'edit' );

        return $this->get_items( $request );
    }

    /**
     * Get registered items
     *
     * @return array
     */
    public function get_registered_items() {
        return [
            'from' => [
                'description' => __( 'The from phone number', 'texty' ),
                'type'        => 'string',
                'required'    => true,
            ],
            'gateway' => [
                'description' => __( 'The selected gateway', 'texty' ),
                'type'        => 'enum',
                'enum'        => array_keys( texty()->gateway()->all() ),
                'required'    => true,
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

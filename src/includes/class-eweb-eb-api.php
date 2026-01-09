<?php
/**
 * Custom REST API Endpoints
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EWEB_EB_API {

	private static $instance = null;

	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	public function register_routes() {
		register_rest_route( 'eweb/v1', '/inject', [
			'methods'  => 'POST',
			'callback' => [ $this, 'handle_injection' ],
			'permission_callback' => '__return_true', 
		] );
	}

	public function handle_injection( $request ) {
		$params = $request->get_json_params();
		$post_id = isset( $params['post_id'] ) ? intval( $params['post_id'] ) : 0;
		$design = isset( $params['design'] ) ? $params['design'] : null;

		if ( ! $post_id && isset( $params['post_title'] ) ) {
			$post_id = wp_insert_post( [
				'post_title'   => $params['post_title'],
				'post_type'    => $params['post_type'] ?? 'page',
				'post_status'  => 'publish',
				'meta_input'   => $params['meta_input'] ?? []
			] );

			if ( is_wp_error( $post_id ) ) {
				return new WP_REST_Response( [ 'status' => 'error', 'message' => $post_id->get_error_message() ], 500 );
			}
		}

		if ( ! $post_id || ! $design ) {
			return new WP_Error( 'missing_params', 'Missing post_id OR post_title/design data', [ 'status' => 400 ] );
		}

		if ( isset( $params['meta_input'] ) && is_array( $params['meta_input'] ) ) {
			foreach ( $params['meta_input'] as $key => $value ) {
				update_post_meta( $post_id, $key, $value );

				if ( '_elementor_conditions' === $key ) {
					$global_conditions = get_option( 'elementor_pro_theme_builder_conditions', [] );
					foreach ( $global_conditions as $condition => $post_ids ) {
						if ( ( $index = array_search( $post_id, (array) $post_ids ) ) !== false ) {
							unset( $global_conditions[ $condition ][ $index ] );
						}
					}
					foreach ( (array) $value as $condition ) {
						$global_conditions[ $condition ][] = $post_id;
					}
					update_option( 'elementor_pro_theme_builder_conditions', $global_conditions );
				}
			}
		}

		$elementor_data = EWEB_EB_Converter::convert( $design );
		update_post_meta( $post_id, '_elementor_data', wp_slash( json_encode( $elementor_data ) ) );
		update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );

		if ( class_exists( '\Elementor\Plugin' ) ) {
			\Elementor\Plugin::$instance->posts_css_manager->clear_cache();
		}

		return new WP_REST_Response( [
			'status' => 'success',
			'message' => 'Design injected into post ' . $post_id,
			'post_id' => $post_id
		], 200 );
	}
}

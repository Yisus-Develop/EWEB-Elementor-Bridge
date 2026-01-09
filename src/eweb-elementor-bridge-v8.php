<?php
/**
 * Plugin Name: EWEB - Elementor Bridge
 * Description: Bridge between Antigravity and Elementor via REST API.
 * Version: 8.0.0
 * Author: Yisus Dev & Antigravity
 */

if ( ! defined( 'ABSPATH' ) ) exit;

final class EWEB_Elementor_Bridge {
	private static $instance = null;

	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init_hooks();
	}

	private function define_constants() {
		define( 'EWEB_EB_VERSION', '8.0.0' );
		define( 'EWEB_EB_PATH', plugin_dir_path( __FILE__ ) );
		define( 'EWEB_EB_URL', plugin_dir_url( __FILE__ ) );
	}

	private function includes() {
		require_once EWEB_EB_PATH . 'includes/class-eweb-eb-api.php';
		require_once EWEB_EB_PATH . 'includes/class-eweb-eb-converter.php';
	}

	private function init_hooks() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
	}

	public function init() {
		EWEB_EB_API::get_instance();
	}

	public function register_widgets( $widgets_manager ) {
		// Load widgets from files
		$widgets_dir = EWEB_EB_PATH . 'widgets/';
		
		// Services Widget
		$services_file = $widgets_dir . 'class-cps-services-asymmetric-widget.php';
		if (file_exists($services_file)) {
			require_once $services_file;
			if (class_exists('CPS_Services_Asymmetric_Widget')) {
				$widgets_manager->register(new \CPS_Services_Asymmetric_Widget());
			}
		}
		
		// Intro Widget
		$intro_file = $widgets_dir . 'class-cps-modern-intro-widget.php';
		if (file_exists($intro_file)) {
			require_once $intro_file;
			if (class_exists('CPS_Modern_Intro_Widget')) {
				$widgets_manager->register(new \CPS_Modern_Intro_Widget());
			}
		}
	}
}

// Initialize
EWEB_Elementor_Bridge::get_instance();

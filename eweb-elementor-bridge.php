 * Plugin Name: EWEB Elementor Bridge (V10.12)
 * Description: [CORE] Unified Industrial Engine.
 * Version: 10.12.0
 * Author: Yisus Dev
 * GitHub Plugin URI: Yisus-Develop/EWEB-Elementor-Bridge
 * Primary Branch: main
 */

if (!defined('ABSPATH')) exit;

/**
 * AUTO-LOADER (The Clean Way)
 */
function cps_v10_register_unified_widgets($widgets_manager) {
    $widgets_dir = __DIR__ . '/widgets/';
    
    if (!is_dir($widgets_dir)) return;

    $files = glob($widgets_dir . "*.php");
    foreach ($files as $file) {
        $filename = basename($file, '.php');
        
        // Skip if it's not a class file or a widget file
        if (strpos($filename, 'class-') !== 0 && strpos($filename, '-widget') === false) continue;

        require_once $file;

        // Class discovery
        $class_name = str_replace(['class-', '-'], ['', '_'], $filename);
        $class_name = ucwords($class_name, '_'); 
        
        if (class_exists($class_name)) {
            $widgets_manager->register(new $class_name());
        }
    }
}
add_action('elementor/widgets/register', 'cps_v10_register_unified_widgets');

/**
 * ASSETS & GSAP
 */
function cps_v10_unified_assets() {
    $css_url = plugin_dir_url(__FILE__) . 'src/core/assets/css/industrial-base.css';
    wp_enqueue_style('cps-industrial-base', $css_url, [], time()); // Bust cache

    // Core GSAP
    wp_enqueue_script('gsap-core', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', [], '3.12.2', true);
    wp_enqueue_script('gsap-scroll', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js', ['gsap-core'], '3.12.2', true);
}
add_action('wp_enqueue_scripts', 'cps_v10_unified_assets');
add_action('elementor/frontend/after_enqueue_styles', 'cps_v10_unified_assets');

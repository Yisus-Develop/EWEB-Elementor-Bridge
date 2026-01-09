<?php
if (!defined('ABSPATH')) exit;

class CPS_V10_Hello_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'cps_v10_hello'; }
    public function get_title() { return 'CPS V10 Hello (Diagnostic)'; }
    public function get_icon() { return 'eicon-code'; }
    public function get_categories() { return ['general']; }
    protected function render() {
        echo '<div style="padding: 20px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px;">';
        echo '<strong>✅ V10 SYSTEM ACTIVE</strong><br>';
        echo 'Architecture: <code>EWEB Elementor Bridge</code><br>';
        echo 'Widget: <code>Hello</code>';
        echo '</div>';
    }
}

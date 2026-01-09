<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'CPS_Modern_Intro_Widget' ) ) {
    class CPS_Modern_Intro_Widget extends \Elementor\Widget_Base {

        public function get_name() { return 'cps_modern_intro'; }
        public function get_title() { return 'CPS Modern Intro'; }
        public function get_icon() { return 'eicon-text-area'; }
        public function get_categories() { return [ 'eweb-v10-category' ]; }

        protected function register_controls() {
            $this->start_controls_section('content_section', ['label' => 'Content']);
            $this->add_control('intro_title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'A NOSSA ESSÊNCIA']);
            $this->add_control('intro_text', ['label' => 'Text', 'type' => \Elementor\Controls_Manager::WYSIWYG, 'default' => 'Texto intro...']);
            $this->end_controls_section();
        }

        protected function render() {
            $settings = $this->get_settings_for_display();
            echo '<div class="cps-modern-intro">';
            echo '<h2 class="meiv-outline">' . esc_html($settings['intro_title']) . '</h2>';
            echo '<div class="intro-content">' . $settings['intro_text'] . '</div>';
            echo '</div>';
        }
    }
}

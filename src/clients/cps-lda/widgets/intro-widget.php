<?php
if (!defined('ABSPATH')) exit;

class CPS_Modern_Intro_Widget extends \Elementor\Widget_Base {
    
    public function get_name() { return 'cps_modern_intro'; }
    public function get_title() { return 'CPS Modern Intro (V10)'; }
    public function get_icon() { return 'eicon-heading'; }
    public function get_categories() { return ['general']; }
    
    protected function register_controls() {
        $this->start_controls_section('section_content', ['label' => 'Content', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT]);
        $this->add_control('intro_text', [
            'label' => 'Intro Text',
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'TRANSFORMANDO DESAFIOS INDUSTRIAIS EM EXCELÊNCIA',
        ]);
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <style>
            .cps-modern-intro { text-align: center; padding: 60px 20px; }
            .cps-intro-text {
                font-family: 'Unbounded', sans-serif; /* Fallback if not loaded */
                font-size: 42px;
                font-weight: 700;
                line-height: 1.2;
                background: linear-gradient(180deg, #FFFFFF 0%, rgba(255,255,255,0.7) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                text-transform: uppercase;
                margin: 0 auto;
                max-width: 1200px;
                letter-spacing: -1px;
            }
            @media (max-width: 768px) { .cps-intro-text { font-size: 28px; } }
        </style>
        <div class="cps-modern-intro">
            <h1 class="cps-intro-text"><?php echo esc_html($settings['intro_text']); ?></h1>
        </div>
        <?php
    }
}

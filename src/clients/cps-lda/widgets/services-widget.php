<?php
if (!defined('ABSPATH')) exit;

class CPS_Services_Asymmetric_Widget extends \Elementor\Widget_Base {
    
    public function get_name() { return 'cps_services_asymmetric'; }
    public function get_title() { return 'CPS Services Grid (Pro)'; }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return ['general']; }
    
    protected function register_controls() {
        // --- CONTENT TAB ---
        $this->start_controls_section('content_section', ['label' => 'Conteúdo', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT]);
        
        $this->add_control('section_title', [
            'label' => 'Título de Sección',
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Nossos Serviços',
        ]);

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('card_title', ['label' => 'Título', 'type' => \Elementor\Controls_Manager::TEXT]);
        $repeater->add_control('card_desc', ['label' => 'Descrição', 'type' => \Elementor\Controls_Manager::TEXTAREA]);
        
        $this->add_control('services_list', [
            'label' => 'Servicios',
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['card_title' => 'Manutenção', 'card_desc' => 'Desc...'],
                ['card_title' => 'Automação', 'card_desc' => 'Desc...'],
                ['card_title' => 'Consultoria', 'card_desc' => 'Desc...'],
            ],
            'title_field' => '{{{ card_title }}}',
        ]);
        $this->end_controls_section();

        // --- STYLE TAB ---
        $this->start_controls_section('style_cards', ['label' => 'Tarjetas', 'tab' => \Elementor\Controls_Manager::TAB_STYLE]);

        // Background Color Control
        $this->add_control('card_bg_color', [
            'label' => 'Color de Fondo',
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cps-service-card' => 'background: {{VALUE}};',
            ],
            'default' => '#1a1a1a',
        ]);

        // Border Radius
        $this->add_responsive_control('card_border_radius', [
            'label' => 'Radio del Borde',
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .cps-service-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        
        $this->end_controls_section();

        // Typography Section
        $this->start_controls_section('style_typography', ['label' => 'Tipografía', 'tab' => \Elementor\Controls_Manager::TAB_STYLE]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => 'Títulos',
                'selector' => '{{WRAPPER}} .cps-service-card h3',
            ]
        );

        $this->add_control('title_color', [
            'label' => 'Color Títulos',
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .cps-service-card h3' => 'color: {{VALUE}}'],
            'default' => '#BCA08A',
        ]);

        $this->end_controls_section();
    }
    
    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <style>
        /* Base Styles (Can be overridden by Elementor Controls) */
        .cps-services-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; }
        .cps-service-card { padding: 40px; border: 1px solid rgba(255,255,255,0.1); position: relative; transition: all 0.3s; }
        .cps-service-card:hover { transform: translateY(-5px); border-color: rgba(188,160,138,0.5); }
        .cps-service-card.large { grid-row: span 2; }
        @media (max-width: 768px) { .cps-services-grid { grid-template-columns: 1fr; } }
        </style>
        
        <div class="cps-services-grid">
            <?php foreach ( $s['services_list'] as $i => $item ) : 
                $class = ($i === 0) ? 'large' : ''; ?>
                <div class="cps-service-card <?php echo $class; ?>">
                    <h3><?php echo esc_html($item['card_title']); ?></h3>
                    <p><?php echo esc_html($item['card_desc']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}

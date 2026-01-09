<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class CPS_Creative_Hero_Widget extends \Elementor\Widget_Base {

public function get_name() { return 'cps_creative_hero'; }
public function get_title() { return 'CPS Creative Hero (Modern)'; }
public function get_icon() { return 'eicon-h-align-right'; }
public function get_categories() { return [ 'general' ]; }

protected function register_controls() {
$this->start_controls_section(
'section_content',
[ 'label' => 'Content', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ]
);
$this->add_control( 'title_top', [ 'label' => 'Title Top', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Encorajando' ] );
$this->add_control( 'title_hollow', [ 'label' => 'Title Hollow', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Excellence' ] );
$this->add_control( 'title_bottom', [ 'label' => 'Title Bottom', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Industrial' ] );
$this->add_control( 'description', [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Especialistas em manutenção industrial e automação.' ] );
$this->add_control( 'image', [ 'label' => 'Side Image', 'type' => \Elementor\Controls_Manager::MEDIA ] );
$this->end_controls_section();
}

protected function render() {
$settings = $this->get_settings_for_display();
$img_url = isset($settings['image']['url']) ? $settings['image']['url'] : '';
?>
<div class="cps-creative-hero-wrapper">
<div class="cps-hero-content">
<div class="cps-hero-titles">
<h1 class="hero-top"><?php echo esc_html($settings['title_top']); ?></h1>
<h1 class="hero-hollow"><?php echo esc_html($settings['title_hollow']); ?></h1>
<h1 class="hero-bottom"><?php echo esc_html($settings['title_bottom']); ?></h1>
</div>
<div class="cps-hero-desc">
<p><?php echo esc_html($settings['description']); ?></p>
<div class="cps-hero-cta">
<a href="#servicos" class="btn-primary">Ver Serviços</a>
<a href="#contacto" class="btn-outline">Contactar</a>
</div>
</div>
</div>
<?php if ($img_url) : ?>
<div class="cps-hero-visual">
<div class="hero-image-parallax" style="background-image: url('<?php echo esc_url($img_url); ?>');"></div>
<div class="hero-shape-overlay"></div>
</div>
<?php endif; ?>
</div>
<?php
}
}

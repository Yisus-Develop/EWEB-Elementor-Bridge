<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CPS_Hero_Liquid_Widget extends \Elementor\Widget_Base {

public function get_name() { return 'cps_hero_liquid'; }
public function get_title() { return 'CPS Hero Liquid (Premium)'; }
public function get_icon() { return 'eicon-parallax'; }
public function get_categories() { return [ 'general' ]; }

protected function register_controls() {
$this->start_controls_section('section_content', ['label' => 'Content']);
$this->add_control('title_line_1', ['label' => 'Title 1', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Encouraging']);
$this->add_control('title_line_2', ['label' => 'Title 2 (Hollow)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Excellence']);
$this->add_control('title_line_3', ['label' => 'Title 3 (Accent)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Industrial']);
$this->add_control('description', ['label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Leading the future of industrial engineering.']);
$this->add_control('main_image', ['label' => 'Main Image', 'type' => \Elementor\Controls_Manager::MEDIA]);
$this->add_control('secondary_image', ['label' => 'Floating Image', 'type' => \Elementor\Controls_Manager::MEDIA]);
$this->end_controls_section();
}

protected function render() {
$s = $this->get_settings_for_display();
$img1 = $s['main_image']['url'] ?? '';
$img2 = $s['secondary_image']['url'] ?? '';
?>
<div class="cps-hero-liquid-wrap">
<div class="cps-hero-mask-container">
<div class="cps-hero-main-img" style="background-image: url('<?php echo esc_url($img1); ?>');"></div>
                <!-- Dark Overlay for Contrast -->
                <div class="cps-hero-overlay"></div>
</div>

<div class="cps-hero-text-layer">
<div class="cps-stagger-titles">
<h1 class="hero-line-solid"><?php echo esc_html($s['title_line_1']); ?></h1>
<h1 class="hero-line-hollow"><?php echo esc_html($s['title_line_2']); ?></h1>
<h1 class="hero-line-accent"><?php echo esc_html($s['title_line_3']); ?></h1>
</div>
<div class="cps-hero-info">
<p><?php echo esc_html($s['description']); ?></p>
<div class="cps-hero-actions">
<a href="#projetos" class="cps-btn-modern">Ver Projetos <span class="arrow">→</span></a>
</div>
</div>
</div>

<?php if($img2): ?>
<div class="cps-hero-floating-box">
<img src="<?php echo esc_url($img2); ?>" alt="Detail">
</div>
<?php endif; ?>
</div>
<?php
}
}

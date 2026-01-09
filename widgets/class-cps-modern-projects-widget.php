<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class CPS_Modern_Projects_Widget extends \Elementor\Widget_Base {

public function get_name() { return 'cps_modern_projects'; }
public function get_title() { return 'CPS Modern Projects (Broken Grid)'; }
public function get_icon() { return 'eicon-gallery-masonry'; }
public function get_categories() { return [ 'general' ]; }

protected function register_controls() {
$this->start_controls_section(
'section_content',
[ 'label' => 'Content', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ]
);
$this->add_control(
'posts_per_page',
[ 'label' => 'Number of Projects', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 5 ]
);
$this->end_controls_section();
}

protected function render() {
$settings = $this->get_settings_for_display();
$query = new \WP_Query([
'post_type' => 'projeto',
'posts_per_page' => $settings['posts_per_page'],
'post_status' => 'publish',
]);

if ( ! $query->have_posts() ) {
echo '<p>No projects found.</p>';
return;
}

echo '<div class="cps-modern-projects-container">';
$index = 1;
while ( $query->have_posts() ) {
$query->the_post();
$img_url = get_the_post_thumbnail_url( get_the_ID(), 'large' ) ?: 'https://cps-lda.pt/wp-content/uploads/2024/03/Imagens-CPS-14.jpg';
$terms = get_the_terms( get_the_ID(), 'tipo_servico' );
$cat_name = $terms && ! is_wp_error( $terms ) ? $terms[0]->name : 'Projeto';

// Layout logic: alternate classes for broken grid
$layout_class = ($index % 2 === 0) ? 'cps-card-right' : 'cps-card-left';
if ($index % 3 === 0) $layout_class .= ' cps-card-wide';

?>
<div class="cps-modern-project-item <?php echo $layout_class; ?>" data-aos="fade-up">
<div class="cps-project-inner">
<div class="cps-project-image-box">
<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title(); ?>">
<div class="cps-project-mask"></div>
</div>
<div class="cps-project-info">
<span class="cps-project-num">0<?php echo $index; ?></span>
<span class="cps-project-tag"><?php echo esc_html( $cat_name ); ?></span>
<h3 class="cps-project-title"><?php the_title(); ?></h3>
<div class="cps-project-line"></div>
<a href="<?php the_permalink(); ?>" class="cps-project-link">
Explorar Proyecto
<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
</a>
</div>
</div>
</div>
<?php
$index++;
}
echo '</div>';
wp_reset_postdata();
}
}

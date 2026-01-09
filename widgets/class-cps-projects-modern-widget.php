<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Modern Projects Widget - Meivcore Style
 * Features: Parallax hover, reveal animations, unique layout
 */
class CPS_Projects_Modern_Widget extends \Elementor\Widget_Base {

	public function get_name() { return 'cps_projects_modern'; }
	public function get_title() { return 'CPS Projects (Modern)'; }
	public function get_icon() { return 'eicon-gallery-masonry'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[ 'label' => 'Content', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ]
		);
		$this->add_control(
			'posts_per_page',
			[ 'label' => 'Number of Projects', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 6 ]
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$args = [
			'post_type' => 'projeto',
			'posts_per_page' => $settings['posts_per_page'],
			'post_status' => 'publish',
		];
		$query = new \WP_Query( $args );

		if ( ! $query->have_posts() ) {
			echo '<p>No projects found.</p>';
			return;
		}

		echo '<div class="cps-projects-modern-grid">';
		$index = 0;
		while ( $query->have_posts() ) {
			$query->the_post();
			$img_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
			if ( ! $img_url ) {
				$img_url = 'https://cps-lda.pt/wp-content/uploads/2024/03/Imagens-CPS-14.jpg';
			}
			
			$terms = get_the_terms( get_the_ID(), 'tipo_servico' );
			$cat_name = $terms && ! is_wp_error( $terms ) ? $terms[0]->name : 'Projeto';
			
			// Alternate layout pattern
			$size_class = ($index % 5 === 0) ? 'cps-project-large' : 'cps-project-regular';
			?>
			<div class="cps-project-modern-card <?php echo $size_class; ?>" data-index="<?php echo $index; ?>">
				<div class="cps-project-image-wrapper">
					<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title(); ?>" class="cps-project-modern-image">
					<div class="cps-project-gradient-overlay"></div>
				</div>
				<div class="cps-project-modern-content">
					<span class="cps-project-number">0<?php echo ($index + 1); ?></span>
					<span class="cps-project-modern-cat"><?php echo esc_html( $cat_name ); ?></span>
					<h3 class="cps-project-modern-title"><?php the_title(); ?></h3>
					<div class="cps-project-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></div>
					<a href="<?php the_permalink(); ?>" class="cps-project-modern-link">
						<span>Ver Projeto</span>
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none">
							<path d="M4 10H16M16 10L10 4M16 10L10 16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
						</svg>
					</a>
				</div>
			</div>
			<?php
			$index++;
		}
		echo '</div>';
		wp_reset_postdata();
	}
}
?>

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class CPS_Projects_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'cps_projects_loop';
	}

	public function get_title() {
		return esc_html__( 'CPS Projects Loop', 'eweb-elementor-bridge' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Query', 'eweb-elementor-bridge' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => esc_html__( 'Posts Per Page', 'eweb-elementor-bridge' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

        // Future: Add category filter
        
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

        if ( $query->have_posts() ) {
            echo '<div class="cps-projects-grid">';
            
            while ( $query->have_posts() ) {
                $query->the_post();
                
                // Get meta
                $local = get_post_meta( get_the_ID(), 'local', true );
                $ano = get_post_meta( get_the_ID(), 'ano', true );
                $featured_img_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                if(!$featured_img_url) $featured_img_url = 'https://via.placeholder.com/800x600';

                // Categories
                $terms = get_the_terms( get_the_ID(), 'categoria_projeto' );
                $cat_name = $terms && ! is_wp_error( $terms ) ? $terms[0]->name : 'Projeto';

                echo '<div class="cps-project-card" onclick="location.href=\'' . get_permalink() . '\'">';
                
                // Image
                echo '<div class="cps-project-image">';
                echo '<img src="' . esc_url($featured_img_url) . '" alt="' . get_the_title() . '">';
                echo '<div class="cps-project-overlay"></div>';
                echo '</div>';
                
                // Content
                echo '<div class="cps-project-content">';
                echo '<div class="cps-project-meta">';
                if($local) echo '<span>' . esc_html($local) . '</span>';
                if($local && $ano) echo '<span class="separator">|</span>';
                if($ano) echo '<span>' . esc_html($ano) . '</span>';
                echo '</div>';
                
                echo '<h3>' . get_the_title() . '</h3>';
                echo '<p class="cps-project-category">' . esc_html($cat_name) . '</p>';
                
                echo '</div>'; // content
                
                echo '</div>'; // card
            }
            
            echo '</div>';
            wp_reset_postdata();
        } else {
            echo '<p>No projects found.</p>';
        }
	}
}

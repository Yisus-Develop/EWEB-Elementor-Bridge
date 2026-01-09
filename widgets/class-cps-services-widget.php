<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class CPS_Services_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'cps_services_grid';
	}

	public function get_title() {
		return esc_html__( 'CPS Services Grid', 'eweb-elementor-bridge' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Services', 'eweb-elementor-bridge' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'eweb-elementor-bridge' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Service Name', 'eweb-elementor-bridge' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'eweb-elementor-bridge' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Service description goes here.', 'eweb-elementor-bridge' ),
			]
		);

		$repeater->add_control(
			'icon_svg',
			[
				'label' => esc_html__( 'Icon SVG Code', 'eweb-elementor-bridge' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'description' => 'Paste exact SVG code from prototype',
			]
		);

        $repeater->add_control(
			'features',
			[
				'label' => esc_html__( 'Features (One per line)', 'eweb-elementor-bridge' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => "Feature 1\nFeature 2\nFeature 3",
			]
		);

        $repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'eweb-elementor-bridge' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'eweb-elementor-bridge' ),
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'services',
			[
				'label' => esc_html__( 'Services List', 'eweb-elementor-bridge' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => esc_html__( 'Mecânica Industrial', 'eweb-elementor-bridge' ),
						'description' => esc_html__( 'Manutenção preventiva e corretiva.', 'eweb-elementor-bridge' ),
                        'features' => "Manutenção Preventiva\nReparação\nOtimização",
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

        echo '<div class="cps-services-grid">';

		foreach ( $settings['services'] as $index => $item ) {
            $paddedIndex = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
            $features = explode("\n", $item['features']);

            // Ensure Link
            $link_url = $item['link']['url'];
            $target = $item['link']['is_external'] ? ' target="_blank"' : '';
            $nofollow = $item['link']['nofollow'] ? ' rel="nofollow"' : '';
            
            // Render Card
			echo '<div class="cps-service-card" onclick="location.href=\'' . esc_url($link_url) . '\'">';
            
            // Number
            echo '<div class="cps-card-number">' . $paddedIndex . '</div>';
            
            // Icon
            echo '<div class="cps-card-icon">';
            if ( ! empty( $item['icon_svg'] ) ) {
                echo $item['icon_svg'];
            } else {
                echo '<i class="fas fa-cog"></i>';
            }
            echo '</div>';
            
            // Title & Desc
            echo '<h3>' . esc_html( $item['title'] ) . '</h3>';
            echo '<p>' . esc_html( $item['description'] ) . '</p>';
            
            // Features
            echo '<div class="cps-card-features"><ul>';
            foreach($features as $feat) {
                if(!empty(trim($feat))) {
                    echo '<li>' . esc_html(trim($feat)) . '</li>';
                }
            }
            echo '</ul></div>';
            
            // Arrow
            echo '<div class="cps-card-arrow">→</div>';

			echo '</div>';
		}

        echo '</div>';
	}
}

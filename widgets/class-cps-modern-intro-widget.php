<?php
/**
 * CPS Modern Intro Widget
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class CPS_Modern_Intro_Widget extends \Elementor\Widget_Base {

	public function get_name() { return 'cps_modern_intro'; }
	public function get_title() { return 'CPS Modern Intro'; }
	public function get_icon() { return 'eicon-t-letter'; }
	public function get_categories() { return [ 'eweb-elements' ]; }

	protected function register_controls() {
		$this->start_controls_section('section_content', ['label' => 'Content']);

		$this->add_control('title', [
			'label' => 'Main Text',
			'type' => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'TRANSFORMING INDUSTRIAL CHALLENGES INTO EXCELLENCE',
		]);

		$this->add_control('accent_color', [
			'label' => 'Accent Color',
			'type' => \Elementor\Controls_Manager::COLOR,
			'default' => '#BCA08A',
		]);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="cps-intro-section">
			<div class="cps-intro-container">
				<h2 class="cps-intro-title" style="color: <?php echo esc_attr($settings['accent_color']); ?>">
					<?php 
					$words = explode(' ', $settings['title']);
					foreach($words as $word) {
						echo '<span class="cps-intro-word">' . esc_html($word) . '</span> ';
					}
					?>
				</h2>
			</div>
		</section>
		<style>
		.cps-intro-section {
			background: #050505;
			padding: 15vh 10vw;
			min-height: 60vh;
			display: flex;
			align-items: center;
			justify-content: center;
			overflow: hidden;
		}
		.cps-intro-title {
			font-family: 'Lalezar', cursive;
			font-size: clamp(3rem, 8vw, 10rem);
			line-height: 0.9;
			text-align: center;
			text-transform: uppercase;
			max-width: 1200px;
		}
		.cps-intro-word {
			display: inline-block;
			opacity: 0;
			filter: blur(10px);
			transform: translateY(40px);
		}
		</style>
		<?php
	}
}

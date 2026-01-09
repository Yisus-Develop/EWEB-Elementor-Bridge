<?php
/**
 * CPS Services Asymmetric Grid Widget
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class CPS_Services_Asymmetric_Widget extends \Elementor\Widget_Base {

	public function get_name() { return 'cps_services_asymmetric'; }
	public function get_title() { return 'CPS Services Asymmetric'; }
	public function get_icon() { return 'eicon-gallery-grid'; }
	public function get_categories() { return [ 'eweb-elements' ]; }

	protected function register_controls() {
		$this->start_controls_section('section_content', ['label' => 'Serviços']);

		$this->add_control('main_title', [
			'label' => 'Título Card Principal',
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'Manutenção Industrial',
		]);

		$this->add_control('main_desc', [
			'label' => 'Descrição Card Principal',
			'type' => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'Líderes em assistência técnica preventiva e corretiva para sistemas complexos.',
		]);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="cps-services-asymmetric-wrap">
			<div class="cps-services-grid">
				<!-- Card Grande -->
				<div class="cps-service-card card-main">
					<div class="card-glow"></div>
					<div class="card-content">
						<span class="card-number">01</span>
						<h3><?php echo esc_html($settings['main_title']); ?></h3>
						<p><?php echo esc_html($settings['main_desc']); ?></p>
						<a href="#" class="card-link">Explorar <i class="fas fa-arrow-right"></i></a>
					</div>
				</div>

				<!-- Cards Pequeñas -->
				<div class="cps-services-subgrid">
					<div class="cps-service-card card-sub">
						<div class="card-glow"></div>
						<div class="card-content">
							<span class="card-number">02</span>
							<h3>Engenharia & Projetos</h3>
							<p>Soluções chave na mão para otimização industrial.</p>
						</div>
					</div>
					<div class="cps-service-card card-sub">
						<div class="card-glow"></div>
						<div class="card-content">
							<span class="card-number">03</span>
							<h3>Montagens Especiais</h3>
							<p>Instalações de alta precisão e equipas certificadas.</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<style>
		.cps-services-asymmetric-wrap {
			background: #050505;
			padding: 100px 5vw;
		}
		.cps-services-grid {
			display: grid;
			grid-template-columns: 1.2fr 1fr;
			gap: 30px;
			max-width: 1400px;
			margin: 0 auto;
		}
		.cps-services-subgrid {
			display: grid;
			grid-template-rows: 1fr 1fr;
			gap: 30px;
		}
		.cps-service-card {
			background: #111;
			border: 1px solid rgba(255,255,255,0.05);
			padding: 50px;
			position: relative;
			overflow: hidden;
			transition: border-color 0.4s ease;
		}
		.cps-service-card:hover { border-color: var(--cps-accent); }
		.card-glow {
			position: absolute;
			top: 0; left: 0; width: 100%; height: 100%;
			background: radial-gradient(600px circle at var(--mouse-x) var(--mouse-y), rgba(188, 160, 138, 0.15), transparent 40%);
			opacity: 0;
			transition: opacity 0.5s ease;
			pointer-events: none;
		}
		.cps-service-card:hover .card-glow { opacity: 1; }
		.card-content { position: relative; z-index: 2; }
		.card-number {
			font-family: 'Space Grotesk', sans-serif;
			font-size: 14px;
			color: var(--cps-accent);
			display: block;
			margin-bottom: 20px;
			opacity: 0.6;
		}
		.cps-service-card h3 {
			font-size: 32px;
			margin-bottom: 20px;
			color: #fff;
		}
		.cps-service-card p {
			color: #888;
			line-height: 1.6;
			font-size: 16px;
		}
		.card-main h3 { font-size: 48px; }
		@media (max-width: 991px) {
			.cps-services-grid { grid-template-columns: 1fr; }
		}
		</style>

		<script>
		document.querySelectorAll('.cps-service-card').forEach(card => {
			card.addEventListener('mousemove', e => {
				const rect = card.getBoundingClientRect();
				const x = e.clientX - rect.left;
				const y = e.clientY - rect.top;
				card.style.setProperty('--mouse-x', `${x}px`);
				card.style.setProperty('--mouse-y', `${y}px`);
			});
		});
		</script>
		<?php
	}
}

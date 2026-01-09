<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'CPS_Meiv_Hero_Widget' ) ) {
class CPS_Meiv_Hero_Widget extends \Elementor\Widget_Base {

	public function get_name() { return 'cps_meiv_hero'; }
	public function get_title() { return 'CPS Meiv Hero (V10)'; }
	public function get_icon() { return 'eicon-heading'; }
	public function get_categories() { return [ 'eweb-v10-category' ]; }

	protected function register_controls() {
		$this->start_controls_section('section_content', ['label' => 'Content']);

		$this->add_control('video_url', [
			'label' => 'Video Overlay URL (MP4)',
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => '',
		]);

		$this->add_control('title_solid', [
			'label' => 'Solid Title',
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'ENCOTRAR SOLUÇÕES',
		]);

		$this->add_control('title_outline', [
			'label' => 'Outline Title',
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'QUE TRANSFORMAM',
		]);

		$this->add_control('subtitle', [
			'label' => 'Subtitle',
			'type' => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'Inovação. Manutenção. Engenharia de Futuro.',
		]);

		$this->end_controls_section();

        $this->start_controls_section('section_style', ['label' => 'Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE]);
        $this->add_control('overlay_color', [
            'label' => 'Overlay Color',
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(0,0,0,0.5)',
            'selectors' => [ '{{WRAPPER}} .meiv-hero-overlay' => 'background: {{VALUE}}' ]
        ]);
        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="meiv-hero-container" style="position:relative; height:100vh; overflow:hidden; background:#000; display:flex; align-items:center; justify-content:center; text-align:center;">
			
            <?php if($settings['video_url']): ?>
            <video autoplay muted loop playsinline class="meiv-hero-video" style="position:absolute; top:50%; left:50%; min-width:100%; min-height:100%; width:auto; height:auto; transform:translate(-50%, -50%); object-fit:cover;">
				<source src="<?php echo esc_url($settings['video_url']); ?>" type="video/mp4">
			</video>
            <?php endif; ?>

			<div class="meiv-hero-bg-container" style="position:absolute; top:0; left:0; width:100%; height:120%; z-index:1; overflow:hidden;">
                <video autoplay muted loop playsinline class="meiv-hero-video" style="width:100%; height:100%; object-fit:cover; opacity:0.6; transform: translateY(0);">
                    <source src="<?php echo esc_url($settings['video_url']); ?>" type="video/mp4">
                </video>
            </div>
            
            <div class="meiv-hero-overlay" style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:2; background: radial-gradient(circle at 50% 50%, rgba(0,0,0,0) 0%, rgba(0,0,0,0.6) 100%);"></div>

			<div class="meiv-hero-content" style="position:relative; z-index:10; color:#fff; width: 90%; max-width: 1200px;">
				<h1 class="meiv-hero-title" style="font-size: clamp(3rem, 10vw, 8rem); font-weight: 900; line-height: 0.9; text-transform: uppercase;">
					<span class="meiv-hero-solid" style="display:block; opacity:0;"><?php echo $settings['title_solid']; ?></span>
					<span class="meiv-outline meiv-outline-gold" style="display:block; margin-top:10px; opacity:0;"><?php echo $settings['title_outline']; ?></span>
				</h1>
				<p class="meiv-hero-subtitle" style="font-size:1.2rem; margin-top:40px; letter-spacing: 4px; text-transform:uppercase; font-weight:300; opacity:0; color: var(--cps-gold);">
                    <?php echo $settings['subtitle']; ?>
                </p>
                <div class="meiv-divider-v" id="meiv-hero-divider"></div>
			</div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    if (window.gsap && window.ScrollTrigger) {
                        gsap.registerPlugin(ScrollTrigger);

                        // 1. Title Entrance (Cinematic)
                        const tl = gsap.timeline({delay: 0.8});
                        tl.fromTo('.meiv-hero-solid', 
                            {opacity: 0, y: 100, filter: 'blur(10px)'}, 
                            {opacity: 1, y: 0, filter: 'blur(0px)', duration: 1.5, ease: 'expo.out'}
                        );
                        tl.fromTo('.meiv-outline', 
                            {opacity: 0, y: 80, filter: 'blur(10px)'}, 
                            {opacity: 1, y: 0, filter: 'blur(0px)', duration: 1.5, ease: 'expo.out'}, 
                            '-=1.2'
                        );
                        tl.to('.meiv-hero-subtitle', {opacity: 1, duration: 2, ease: 'power2.out'}, '-=0.8');
                        tl.to('#meiv-hero-divider', {height: 80, duration: 1.5, ease: 'power4.inOut'}, '-=1.5');

                        // 2. Parallax Effect
                        gsap.to('.meiv-hero-video', {
                            yPercent: 20,
                            ease: 'none',
                            scrollTrigger: {
                                trigger: '.cps-meiv-hero',
                                start: 'top top',
                                end: 'bottom top',
                                scrub: true
                            }
                        });
                    }
                });
            </script>
		</section>
		<?php
	}
}
}

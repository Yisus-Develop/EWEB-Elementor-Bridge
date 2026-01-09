<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CPS_Meiv_Sectors_Widget extends \Elementor\Widget_Base {

	public function get_name() { return 'cps_meiv_sectors'; }
	public function get_title() { return 'CPS Meiv Sectors (V10)'; }
	public function get_icon() { return 'eicon-gallery-grid'; }
	public function get_categories() { return [ 'eweb-v10-category' ]; }

	protected function register_controls() {
		$this->start_controls_section('section_sectors', ['label' => 'Sectors']);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control('sector_title', [
			'label' => 'Title',
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'Sector Name',
		]);

		$repeater->add_control('sector_image', [
			'label' => 'Background Image',
			'type' => \Elementor\Controls_Manager::MEDIA,
		]);

		$repeater->add_control('sector_link', [
			'label' => 'Link',
			'type' => \Elementor\Controls_Manager::URL,
		]);

		$this->add_control('sectors_list', [
			'label' => 'Sectors List',
			'type' => \Elementor\Controls_Manager::REPEATER,
			'fields' => $repeater->get_controls(),
			'default' => [
				['sector_title' => 'ENERGIA'],
				['sector_title' => 'AUTOMÓVEL'],
				['sector_title' => 'METALOMECÂNICA'],
			],
			'title_field' => '{{{ sector_title }}}',
		]);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="meiv-sectors-grid meiv-focus-group" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:0;">
			<?php foreach ($settings['sectors_list'] as $item): 
                $img = !empty($item['sector_image']['url']) ? $item['sector_image']['url'] : 'https://via.placeholder.com/600x800/1a1a1a/BCA08A?text=CPS+Sector';
            ?>
				<a href="<?php echo esc_url($item['sector_link']['url']); ?>" class="meiv-sector-card meiv-card-container meiv-focus-item meiv-clip-reveal" style="position:relative; height: 600px; display:flex; align-items:flex-end; padding:60px; text-decoration:none; overflow:hidden; border:none;">
					<div class="meiv-sector-bg" style="position:absolute; top:0; left:0; width:100%; height:110%; background: url(<?php echo esc_url($img); ?>) center/cover no-repeat; transition: transform 1.2s cubic-bezier(0.165, 0.84, 0.44, 1); filter: grayscale(1) brightness(0.6);"></div>
                    <div class="meiv-sector-overlay" style="position:absolute; top:0; left:0; width:100%; height:100%; background: linear-gradient(0deg, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0) 60%); transition: opacity 0.6s ease;"></div>
					
					<div class="meiv-sector-info" style="position:relative; z-index:5; width: 100%;">
						<h3 class="meiv-sector-title" style="color:#fff; font-size: 2.5rem; font-weight: 900; text-transform:uppercase; margin:0; letter-spacing:1px; line-height:1; transition: transform 0.6s ease;"><?php echo $item['sector_title']; ?></h3>
                        <div class="meiv-divider-h" style="width: 40px; height: 2px; background: var(--cps-gold); margin-top:20px; transition: width 0.6s cubic-bezier(0.77, 0, 0.175, 1);"></div>
					</div>

                    <style>
                        .meiv-sector-card:hover .meiv-sector-bg { transform: scale(1.15) translateY(-5%); filter: grayscale(0) brightness(1); }
                        .meiv-sector-card:hover .meiv-divider-h { width: 100%; }
                        .meiv-sector-card:hover .meiv-sector-title { transform: translateY(-10px); color: var(--cps-gold); }
                    </style>
				</a>
			<?php endforeach; ?>
		</div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });

                document.querySelectorAll('.meiv-clip-reveal').forEach(el => observer.observe(el));
            });
        </script>
		<?php
	}
}

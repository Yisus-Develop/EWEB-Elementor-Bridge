<?php
if (!defined('ABSPATH')) exit;

class CPS_Projects_Loop_Widget extends \Elementor\Widget_Base {
    
    public function get_name() { return 'cps_projects_loop'; }
    public function get_title() { return 'CPS Projects Loop (Debug)'; }
    public function get_icon() { return 'eicon-posts-grid'; }
    public function get_categories() { return ['general']; }
    
    protected function register_controls() {
        $this->start_controls_section('query_section', ['label' => 'Consulta', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT]);
        $this->add_control('posts_per_page', [
            'label' => 'Total',
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 6,
        ]);
        $this->end_controls_section();
    }
    
    protected function render() {
        $s = $this->get_settings_for_display();
        
        // Render

        
        // Basic args
        $args = [
            'post_type' => 'projeto',
            'posts_per_page' => $s['posts_per_page'],
            'post_status' => 'publish', // Ensure we only get published
        ];
        
        $query = new \WP_Query($args);
        
        // CSS
        ?>
        <style>
            .cps-projects-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 50px; }
            .cps-project-card { background: #1a1a1a; border-radius: 8px; overflow: hidden; position: relative; height: 400px; transition: transform 0.3s ease; }
            .cps-project-card:hover { transform: translateY(-10px); }
            .cps-project-img { width: 100%; height: 100%; object-fit: cover; transition: opacity 0.3s; opacity: 0.6; }
            .cps-project-card:hover .cps-project-img { opacity: 0.3; }
            .cps-project-info { position: absolute; bottom: 0; left: 0; width: 100%; padding: 30px; background: linear-gradient(to top, rgba(0,0,0,0.9), transparent); }
            .cps-cat-badge { background: #BCA08A; color: #000; padding: 4px 8px; font-size: 10px; font-weight: bold; text-transform: uppercase; border-radius: 2px; }
            .cps-project-title { color: #fff; margin: 10px 0 5px; font-size: 24px; font-family: sans-serif; }
            .cps-project-link { color: #fff; text-decoration: none; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center; gap: 5px; }
        </style>
        
        <div class="cps-projects-section">
            <?php if ($query->have_posts()) : ?>
                <div class="cps-projects-container">
                    <?php while ($query->have_posts()) : $query->the_post(); 
                        $cats = get_the_terms(get_the_ID(), 'categoria_projeto');
                        $cat_name = ($cats && !is_wp_error($cats)) ? $cats[0]->name : 'PROJETO';
                        $img_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : 'https://via.placeholder.com/600x800/111/333?text=NO+IMAGE';
                    ?>
                        <article class="cps-project-card">
                            <img src="<?php echo esc_url($img_url); ?>" class="cps-project-img" alt="<?php the_title(); ?>">
                            <div class="cps-project-info">
                                <span class="cps-cat-badge"><?php echo esc_html($cat_name); ?></span>
                                <h3 class="cps-project-title"><?php the_title(); ?></h3>
                                <a href="<?php the_permalink(); ?>" class="cps-project-link">VER DETALHES &rarr;</a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <div style="color:white; text-align:center; padding:50px; border:1px solid red;">
                    <h3>NO PROJECTS FOUND</h3>
                    <p>Query Args: <?php echo json_encode($args); ?></p>
                    <p>Post Type Exists? <?php echo post_type_exists('projeto') ? 'YES' : 'NO'; ?></p>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}

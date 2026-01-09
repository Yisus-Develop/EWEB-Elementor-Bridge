<?php
/**
 * Register Custom Post Type: Projetos
 * 
 * Este archivo registra el CPT para Proyectos que será usado con ACF/SCF
 * y Elementor Loop para mostrar los proyectos de CPS LDA.
 * 
 * Instrucciones:
 * 1. Añadir este código a functions.php del tema hijo, o
 * 2. Crear un plugin mu-plugin, o
 * 3. Usar el plugin EWEB Starter Helper para incluirlo
 * 
 * @package CPS_LDA
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Projetos CPT
 */
function cps_register_projetos_cpt() {
    $labels = array(
        'name'                  => _x( 'Projetos', 'Post type general name', 'cps-lda' ),
        'singular_name'         => _x( 'Projeto', 'Post type singular name', 'cps-lda' ),
        'menu_name'             => _x( 'Projetos', 'Admin Menu text', 'cps-lda' ),
        'name_admin_bar'        => _x( 'Projeto', 'Add New on Toolbar', 'cps-lda' ),
        'add_new'               => __( 'Adicionar Novo', 'cps-lda' ),
        'add_new_item'          => __( 'Adicionar Novo Projeto', 'cps-lda' ),
        'new_item'              => __( 'Novo Projeto', 'cps-lda' ),
        'edit_item'             => __( 'Editar Projeto', 'cps-lda' ),
        'view_item'             => __( 'Ver Projeto', 'cps-lda' ),
        'all_items'             => __( 'Todos os Projetos', 'cps-lda' ),
        'search_items'          => __( 'Pesquisar Projetos', 'cps-lda' ),
        'not_found'             => __( 'Nenhum projeto encontrado.', 'cps-lda' ),
        'not_found_in_trash'    => __( 'Nenhum projeto no lixo.', 'cps-lda' ),
        'featured_image'        => _x( 'Imagem do Projeto', 'Overrides the "Featured Image"', 'cps-lda' ),
        'set_featured_image'    => _x( 'Definir imagem do projeto', 'Overrides "Set featured image"', 'cps-lda' ),
        'archives'              => _x( 'Arquivo de Projetos', 'Archives label', 'cps-lda' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true, // Importante para Elementor Loop y Gutenberg
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'projeto', 'with_front' => false ),
        'capability_type'    => 'post',
        'has_archive'        => 'projetos',
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array( 
            'title', 
            'editor', 
            'thumbnail', 
            'excerpt',
            'custom-fields' 
        ),
    );

    register_post_type( 'projeto', $args );
}
add_action( 'init', 'cps_register_projetos_cpt' );

/**
 * Register Categorias de Projeto Taxonomy
 */
function cps_register_projeto_taxonomies() {
    // Categoria de Projeto (Portugal, Internacional, etc.)
    $cat_labels = array(
        'name'              => _x( 'Categorias', 'taxonomy general name', 'cps-lda' ),
        'singular_name'     => _x( 'Categoria', 'taxonomy singular name', 'cps-lda' ),
        'search_items'      => __( 'Pesquisar Categorias', 'cps-lda' ),
        'all_items'         => __( 'Todas as Categorias', 'cps-lda' ),
        'edit_item'         => __( 'Editar Categoria', 'cps-lda' ),
        'update_item'       => __( 'Atualizar Categoria', 'cps-lda' ),
        'add_new_item'      => __( 'Adicionar Nova Categoria', 'cps-lda' ),
        'new_item_name'     => __( 'Nome da Nova Categoria', 'cps-lda' ),
        'menu_name'         => __( 'Categorias', 'cps-lda' ),
    );

    $cat_args = array(
        'hierarchical'      => true,
        'labels'            => $cat_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'categoria-projeto' ),
    );

    register_taxonomy( 'categoria_projeto', array( 'projeto' ), $cat_args );

    // Tipo de Serviço (Manutenção, Automação, etc.)
    $tipo_labels = array(
        'name'              => _x( 'Tipos de Serviço', 'taxonomy general name', 'cps-lda' ),
        'singular_name'     => _x( 'Tipo de Serviço', 'taxonomy singular name', 'cps-lda' ),
        'search_items'      => __( 'Pesquisar Tipos', 'cps-lda' ),
        'all_items'         => __( 'Todos os Tipos', 'cps-lda' ),
        'edit_item'         => __( 'Editar Tipo', 'cps-lda' ),
        'update_item'       => __( 'Atualizar Tipo', 'cps-lda' ),
        'add_new_item'      => __( 'Adicionar Novo Tipo', 'cps-lda' ),
        'new_item_name'     => __( 'Nome do Novo Tipo', 'cps-lda' ),
        'menu_name'         => __( 'Tipos de Serviço', 'cps-lda' ),
    );

    $tipo_args = array(
        'hierarchical'      => false,
        'labels'            => $tipo_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'tipo-servico' ),
    );

    register_taxonomy( 'tipo_servico', array( 'projeto' ), $tipo_args );
}
add_action( 'init', 'cps_register_projeto_taxonomies' );

/**
 * Flush rewrite rules on activation
 * Call this once after registering CPT (via plugin activation hook or manually)
 */
function cps_flush_rewrite_rules() {
    cps_register_projetos_cpt();
    cps_register_projeto_taxonomies();
    flush_rewrite_rules();
}
// Uncomment to flush rules (run once, then comment again):
// add_action( 'init', 'cps_flush_rewrite_rules', 99 );

<?php
/**
 * Plugin Name: CPS Site Core (Data)
 * Description: [CORE] Registers Custom Post Types (Projetos) and Taxonomies. Defines the Data Architecture.
 * Version: 1.0.0
 * Author: Yisus Dev
 */

if (!defined('ABSPATH')) exit;

function cps_register_cpt_projeto() {
    $labels = array(
        'name'                  => 'Projetos',
        'singular_name'         => 'Projeto',
        'menu_name'             => 'Projetos',
        'add_new'               => 'Adicionar Novo',
        'add_new_item'          => 'Adicionar Novo Projeto',
        'edit_item'             => 'Editar Projeto',
        'new_item'              => 'Novo Projeto',
        'view_item'             => 'Ver Projeto',
        'all_items'             => 'Todos os Projetos',
        'search_items'          => 'Pesquisar Projetos',
        'not_found'             => 'Nenhum projeto encontrado',
        'not_found_in_trash'    => 'Nenhum projeto encontrado no lixo',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'projetos'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => true,
    );

    register_post_type('projeto', $args);
}
add_action('init', 'cps_register_cpt_projeto');

function cps_register_taxonomies() {
    // Taxonomy: Categoria de Projeto
    $labels_cat = array(
        'name'              => 'Categorias de Projeto',
        'singular_name'     => 'Categoria',
        'search_items'      => 'Pesquisar Categorias',
        'all_items'         => 'Todas as Categorias',
        'edit_item'         => 'Editar Categoria',
        'update_item'       => 'Atualizar Categoria',
        'add_new_item'      => 'Adicionar Nova Categoria',
        'new_item_name'     => 'Nome da Nova Categoria',
        'menu_name'         => 'Categorias',
    );

    $args_cat = array(
        'hierarchical'      => true,
        'labels'            => $labels_cat,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'categoria-projeto'),
        'show_in_rest'      => true,
    );

    register_taxonomy('categoria_projeto', array('projeto'), $args_cat);
}
add_action('init', 'cps_register_taxonomies');

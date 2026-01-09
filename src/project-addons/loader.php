<?php
/**
 * Project Addons Loader
 * 
 * This folder contains project-specific customizations.
 * Each subfolder represents a different project and can be enabled/disabled.
 * 
 * Structure:
 * /project-addons/
 *   /cps-lda/        <- CPS LDA specific customizations
 *   /other-project/  <- Another project's customizations
 * 
 * To enable a project's addons, add its folder name to the active_projects array below.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Active Projects
 * Add folder names here to enable their customizations
 */
$active_projects = [
    'cps-lda',  // CPS LDA - Projetos CPT and customizations
];

/**
 * Load active project addons
 */
foreach ( $active_projects as $project ) {
    $project_path = EWEB_EB_PATH . 'project-addons/' . $project . '/';
    
    if ( is_dir( $project_path ) ) {
        // Load all PHP files from the project folder
        $files = glob( $project_path . '*.php' );
        foreach ( $files as $file ) {
            require_once $file;
        }
    }
}

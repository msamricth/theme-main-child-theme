<?php
/**
 * Template file: inc/enqueue.php
 * Settings that came with the original Boiler point
 *
 * @package Child theme
 * @since v1
 */

/**
 * Loading All CSS Stylesheets and Javascript Files.
 *
 * @since v1.0
 */
// Enqueue parent theme style
add_action('wp_enqueue_scripts', 'enqueue_parent_styles');
// Enqueue parent theme styles and scripts
function enqueue_parent_styles() {
    // Enqueue parent theme style
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

add_action('wp_enqueue_scripts', 'enqueue_theme_assets');
// Enqueue parent theme styles and scripts
function enqueue_theme_assets() {
    // Enqueue parent theme style
    wp_enqueue_style('main-style', get_stylesheet_directory_uri() . '/build/main.css');
    
    wp_enqueue_script('main-script', get_stylesheet_directory_uri() . '/build/main.js', array(), '1', true);
}
function dequeue_parent_theme_styles() {
    // Replace 'parent-style' with the handle of the parent theme's stylesheet
    wp_dequeue_style('main');
    wp_deregister_style('main');
}
add_action('wp_enqueue_scripts', 'dequeue_parent_theme_styles', 20);
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



/**
 * Add inline styles to the <head> section of the child theme, this is just for the first few things so they load fast while the rest of the assets load
 */
function add_custom_inline_styles_to_head() {
    // Define your custom inline styles here
    $custom_styles = '
    .hero-title {
        font-weight: 700;
        font-style: italic;
        --theme-main-animation-delay: 0.6s;
        font-family: "Josefin Sans", sans-serif;
    }
    ';

    // Output the custom styles inside <style> tags
    echo '<style type="text/css">' . $custom_styles . '</style>';
}

// Hook the function into the wp_head action
add_action('wp_head', 'add_custom_inline_styles_to_head', 1);

function preloadGoogleFonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@1,700&display=swap" rel="stylesheet">';
}

// Hook the function into the wp_head action
add_action('wp_head', 'preloadGoogleFonts', 1);



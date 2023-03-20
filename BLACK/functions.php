<?php


add_action('after_setup_theme', function () {

    
    add_theme_support('title-tag');

    add_theme_support('wp-block-styles');

 
    add_theme_support('align-wide');

 
    add_theme_support('editor-styles');

    add_theme_support('responsive-embeds');

    add_filter('show_admin_bar', '__return_false');

});



add_action('wp_enqueue_scripts', function () use ($version) {
    
    wp_enqueue_style('webdev-css', get_template_directory_uri() . '/style.css');
});

?>


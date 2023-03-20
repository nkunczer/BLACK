<?php

add_action('wp_enqueue_scripts', function () use ($version) {
    
    wp_enqueue_style('webdev-css', get_template_directory_uri() . '/style.css');
});

?>


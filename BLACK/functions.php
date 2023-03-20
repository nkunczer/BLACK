<?php


add_action('after_setup_theme', function () {

    
    add_theme_support('title-tag');


  
    load_textdomain('wifi', get_template_directory() . '/assets/languages');

       


 
    add_theme_support('html5', array(
        'search-form',
        'gallery',
        'caption',
        'style',
        'script',
        'comment-list',
        'comment-form'
    ));






    
    register_nav_menus(array(
        'primary' => __('Haupt Navigation', 'wifi'),
        'footer' => __('Footer Navigation', 'wifi'),
    ));


    


   
    add_theme_support('wp-block-styles');

 
    add_theme_support('align-wide');

 
    add_theme_support('editor-styles');



    add_theme_support('responsive-embeds');

    add_filter('show_admin_bar', '__return_false');

});






$theme_version = wp_get_theme()->get( 'Version' );
$version = is_string( $theme_version ) ? $theme_version : false;

add_action('wp_enqueue_scripts', function () use ($version) {
    
    // CSS (style.css) im Head einfügen
    wp_enqueue_style('icons-css', get_template_directory_uri() . '/assets/icons/style.min.css');
    wp_enqueue_style('webdev-css', get_template_directory_uri() . '/style.css');

   

});



add_filter('show_admin_bar', '__return_false');



/* --- Custom Post Types ---
* Mit Custom Post Types können eigenen Beitrags- und/oder Seitentypen angelegt werden - eigener Menüpunkt im Admin-Menü
* Der Funktionsaufruf register_post_type() wird in einem "init" Hook ( "add_action('init', 'FUNKTIONSNAME',0)" ) in WordPress eingebunden.
* https://developer.wordpress.org/reference/hooks/init/
*/

/* Register Custom Post Type für Projekte
* Hilfreiches Tool zur generierung des Code: https://generatewp.com/post-type/
* WordPress Doku: https://developer.wordpress.org/reference/functions/register_post_type/
*/
function post_type_project()
{

    $labels = array(
        'name' => _x('Projekte', 'Post Type General Name', 'wifi'),
        'singular_name' => _x('Projekt', 'Post Type Singular Name', 'wifi'),
        'menu_name' => __('Projekte', 'wifi'),
        'name_admin_bar' => __('Projekte', 'wifi'),
        'archives' => __('Projekte Archiv', 'wifi'),
        'attributes' => __('Projekt Attribute', 'wifi'),
        'parent_item_colon' => __('Parent-Projekt:', 'wifi'),
        'all_items' => __('Alle Projekte', 'wifi'),
        'add_new_item' => __('neues Projekt hinzufügen', 'wifi'),
        'add_new' => __('Neues hinzufügen', 'wifi'),
        'new_item' => __('Neues Projekt', 'wifi'),
        'edit_item' => __('Projekt bearbeiten', 'wifi'),
        'update_item' => __('Aktualisiere Projekt', 'wifi'),
        'view_item' => __('zeige Projekt', 'wifi'),
        'view_items' => __('Zeige Projekte', 'wifi'),
        'search_items' => __('Suche Projekt', 'wifi'),
        'not_found' => __('Nichts gefunden', 'wifi'),
        'not_found_in_trash' => __('Not found in Trash', 'wifi'),
        'featured_image' => __('Projektbild', 'wifi'),
        'set_featured_image' => __('Als Projektbild festlegen', 'wifi'),
        'remove_featured_image' => __('Remove featured image', 'wifi'),
        'use_featured_image' => __('Als Projektbild verwenden', 'wifi'),
        'insert_into_item' => __('In Projekt einfügen', 'wifi'),
        'uploaded_to_this_item' => __('Zu Projekt hochladen', 'wifi'),
        'items_list' => __('Projekt Liste', 'wifi'),
        'items_list_navigation' => __('Projekte', 'wifi'),
        'filter_items_list' => __('Filter Projekt Liste', 'wifi'),
    );
    $args = array(
        'label' => __('Projekt', 'wifi'),
        'labels' => $labels,
        'supports' => array('title','editor'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 10,
        'menu_icon' => 'dashicons-format-gallery',  // https://developer.wordpress.org/resource/dashicons/
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => false,
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
        'show_in_rest' => true, // true => zugleich Gutenberg Editor (würde das Portfolio rein mit ACF-Feldern aufgebaut werden, dann false)
    );

    register_post_type('project', $args);

}

add_action('init', 'post_type_project', 0);




/* --- Pagination für Custom-Query --- */

/*
 * https://developer.wordpress.org/reference/classes/wp_query/
 * https://developer.wordpress.org/reference/functions/paginate_links/
 * str_replace() = https://www.php.net/manual/de/function.str-replace.php
 */
function pagination( $paged = '', $max_page = '' ) {
    $big = 999999999; // need an unlikely integer
    if( ! $paged ) {
        $paged = get_query_var('paged');
    }

    if( ! $max_page ) {
        global $wp_query;
        $max_page = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
    }

    $html = '<nav class="pagination">';
    $html.= paginate_links( array(
        'base'       => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'     => '?paged=%#%',
        'current'    => max( 1, $paged ),
        'total'      => $max_page,
        'mid_size'   => 1,
        'prev_text'  => '<span class="icon-arrow-left" aria-label="' . __('Vorherige Seite', 'wifi') . '"></span>',
        'next_text'  => '<span class="icon-arrow-right" aria-label="' . __('Nächste Seite', 'wifi') . '"></span>'
    ) );
    $html .= '</nav>';
    echo $html;
}




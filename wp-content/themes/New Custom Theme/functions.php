<?php
function newcustomtheme_script_enqueue()
{
    wp_enqueue_style('customstyle', get_template_directory_uri() . '/custom/custom.css', [], '1.0.1', 'all');
    wp_enqueue_script('customjs', get_template_directory_uri() . '/custom/custom.js', [], '1.0.1', true);

    //Bootstrap
    wp_register_style('bootstrapcss', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css', [], '5.2.3', 'all');
    wp_enqueue_style('bootstrapcss');

    wp_register_script('jsbootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js', [], '5.2.3', false);
    wp_enqueue_script('jsbootstrap');
}

add_action('wp_enqueue_scripts', 'newcustomtheme_script_enqueue');

//ADD MENUS: HEADER AND FOOTER
function newcustomtheme_setup()
{
    //add menu
    add_theme_support('menus');
    register_nav_menu('primary', 'primary_header');
    register_nav_menu('secondary', 'footer_navigation');
}

// ADDING NAVWALKER CLASS
if (!file_exists(get_template_directory() . '/class-wp-bootstrap-navwalker.php')) {
    return new WP_Error('class-wp-bootstrap-navwalker-missing', __('It appears the class-wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker'));
} else {
    require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}

add_action('init', 'newcustomtheme_setup');

/**
 * THEME SUPPORT
 */

add_theme_support('custom-background');
add_theme_support('custom-header');
add_theme_support('post-thumbnails');

add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat']);

//CUSTOM POST TYPE
function portfolio_post_type(){
    $labels=[
        'name'=>'Portfolios',
        'singular_name'=>'Portfolio',
        'add_new'=>'Add Portfolio Item',
        'all_items'=>'All Portfolios',
        'add_new_item'=>'Edit Item',
        'new_item'=>'New Item',
        'view_item'=>'View Item',
        'search_item'=>'Search Portfolio',
        'not_found'=>'No Items Found',
        'not_found_in_trash'=>'No items found in trash',
        'parent_item_colon'=>'Parent Item'
    ];

    $args = [
        'labels'=>$labels,
        'public'=>true,
        'has_archive'=>true,
        'publicly_queryable'=>true,
        'query_var'=>true,
        'rewrite'=>true,
        'capability'=>'post',
        'hierarchical'=>false,
        'supports'=>[
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'revisions',
        ],
        'taxonomies'=>[
            'category',
            'post_tag',
            'menu_position'=> 5,
            'exclude_from_search'=>false
        ]
    ];

    register_post_type('portfolio', $args);
    //portfolio is going to create the slug for permalink and $args is going to create the post type
}
add_action('init', 'portfolio_post_type');
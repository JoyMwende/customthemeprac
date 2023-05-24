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

//custom taxonomy
function career_custom_taxonomy(){
    $labels = [
        'name'=> 'Careers',
        'singular_name'=>'Career',
        'search_items'=> 'Search Careers',
        'all_items'=>'All Careers',
        'parent_item'=>'Parent Career',
        'parent_item_colon'=>'Parent Career:',
        'edit_item'=>'Edit Career',
        'update_item'=>'Update Career',
        'add_new_item'=>'Add New Career',
        'new_item_name'=>'New Career Name',
        'menu_name'=>'Careers'
    ];

    $args = [
        'labels'=>$labels,
        'hierarchical'=>true,
        'show_ui'=>true,
        'show_admin_column'=>true,
        'query_var'=>true,
        'rewrite'=>[
            'slug'=>'career'
        ]
        ];

        register_taxonomy('career', ['portfolio'], $args);

        //non-hierarchical taxonomy
        register_taxonomy('software', ['portfolio'], [
            'hierarchical'=>false,
            'label'=> 'Software',
            'show_ui' => true,
            'show_admin_column'=>true,
            'query_var'=>true,
            'rewrite'=>[
                'slug'=> 'software'
            ]
        ]);
}
add_action('init', 'career_custom_taxonomy');

//custom term function
function customterm_get_terms($postID, $term){
    $termslist = wp_get_post_terms($postID, $term);

    $i = 0;
    $output = '';
    foreach($termslist as $term){
        $i++;

        if($i>1){
            $output .= ", ";
        }

        // $output .= $term->name;

        // $output .= get_term_link($term);
        $output .= '<a href="'. get_term_link($term).'">' .$term->name. '</a>';
    }

    return $output; 
}

//global variable
global $successmessage;
$successmessage;

global $errormessage;
$errormessage;


//securing admin dashboard
//new login url
// function new_login_url($login_url){
//     $login_url = site_url(
//         'joy.php', 'login'
//     );
//     return $login_url;
// }
// add_filter('login_url', 'new_login_url');


//limit login attempts
function check_attempted_login($user, $username, $password){
    if(get_transient('attempted_login')){
        $datas = get_transient('attempted_login');

        if($datas['tried'] >= 3){
            $until = get_option("_transient_timeout_" . "attempted_login");
            $time = time_to_go($until);

            return new WP_Error('too_many_attempts' , sprintf(__('<strong> ERROR </strong>: You have reached the aunthentication limit, please try after %1$s'), $time));
        }
    }

    return $user;
}

add_filter('authenticate', 'check_attempted_login', 30, 3);

function login_failed($username){
    if (get_transient('attempted_login')){
        $datas = get_transient('attempted_login');

        $datas['tried']++;

        if($datas['tried'] <= 3) set_transient('attempted_login', $datas, 300);
        } else {
            $datas = [
                'tried' => 1
            ];
            set_transient('attempted_login', $datas, 300);
        }
    
}
add_action('wp_login_failed', 'login_failed', 10, 1);
function time_to_go($timestamp){
    $periods = [
        'second',
        'minute',
        'hour',
        'day',
        'week',
        'month',
        'year'
    ];
    $lengths = [
        '60',
        '60',
        '24',
        '7',
        '4.35',
        '12'
    ];

    $current_timestamp = time();
    $difference = abs($current_timestamp - $timestamp);

    for ($i = 0; $difference >= $lengths[$i] && $i < count($lengths) - 1; $i ++) {
        $difference /= $lengths[$i];
    }
    //add countdown
    $difference = round($difference);

    if (isset($difference)){
        if($difference != 1){
            $periods[$i] .= 's';
            $output = "$difference $periods[$i]";
            return $output;
        }
    }
    
}
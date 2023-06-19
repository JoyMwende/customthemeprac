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

//adding short code
add_shortcode('c13code', function($atts){
    $attributes = shortcode_atts([
        'members'=>'Joel, Joy, Hope, Kimani',
        'no_of_trainees'=>4
    ], $atts, 'c13code');

    return 'Members = ' .$attributes['members'] .' No of trainees = ' .$attributes['no_of_trainees'];
});


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


/**
 * WORDPRESS REST API
 * 
 * 
 * Creating custom field REST API
 */

 function custom_field_rest_api(){
    register_rest_field('post', 'custom_field1', ['get_callback'=>'get_custom_field']);

    register_rest_route('portfolio/v1', 'c13-portfolios', [
        'callback' => 'get_c13_portfolio',
        //setting permission
        'method' => 'GET',
        'permission_callback'=>'custom_endpoint_permission',
        'args' => [
            'meta_key' => [
                'required' => true,
                'default' => '_edit_last',
                'validate_callback' => function($param, $request, $key){
                    return !is_numeric($param);
                }
            ],
            'meta_value' => [
                'required' => true,
                'default' => 1,
                'validate_callback' => function($param, $request, $key){
                    return is_numeric($param);
                }
            ]
            ],
            //rest api schema
            'schema' => 'myportfolio_schema'
    ]);
 }

 function myportfolio_schema(){
    $schema = [
        'schema' => '',
        'title' => 'all-portfolio',
        'type' => 'object',
        'properties' => [
            'id'=> [
                'description' => esc_html__('unique identifier of the object', 'my-textdomain'),
                'type' => 'integer'
            ],
            'author' => [
                'description'=>esc_html__('The creator of the object', 'my-textdomain'),
                'type'=>'integer'
            ],
            'title' => [
                'description'=>esc_html__('This is the title of the portfolio', 'my-textdomain'),
                'type'=>'string'
            ],
            'content' => [
                'description'=>esc_html__('The content of the portfolio', 'my-textdomain'),
                'type'=>'string'
            ]
        ]
            ];

            return $schema;
 }

 function get_custom_field($obj){
    $post_id = $obj['id'];

    echo '<pre>'; print_r($post_id); '</pre>';
    return get_post_meta($post_id, 'customField1', true); //the second parameter is the name of the custom field in the frontend(wordpress)
 }

 add_action('rest_api_init', 'custom_field_rest_api');

 //custom endpoints using REST API
 function get_c13_portfolio(WP_REST_Request $request){
    $meta_key = $request->get_param('meta_key');
    $meta_value = $request->get_param('meta_value');

    $args = [
        'post_type' => 'portfolio',
        'status' =>'publish',
        'posts_per_page'=>10,
        'meta_query' => [[
            'key' => $meta_key,
            'value' => $meta_value
        ]]
        ];

        $the_query = new WP_Query($args);

        $portfolios = $the_query->posts;

        if(empty($portfolios)){
            return new WP_Error(
                'no_data_found',
                'No Data Found',
                [
                    'status' => 404
                ]
                );
        }

        foreach($portfolios as $portfolio){
            $response = custom_rest_prepare_post($portfolio, $request);
            $data[] = custom_prepare_for_collection($response);
        }

        return rest_ensure_response($data);
 }

 function custom_rest_prepare_post($post, $request){
    $post_data = [];
    $schema = myportfolio_schema();

    if(isset($schema['properties']['id'])){
        $post_data['id'] = (int) $post->ID;
    }
    if(isset($schema['properties']['id'])){
        $post_data['author'] = (int) $post->post_author;
    }
    if(isset($schema['properties']['id'])){
        $post_data['title'] = apply_filters('post_text', $post->post_title, $post);
    }
    if(isset($schema['properties']['id'])){
        $post_data['content'] = apply_filters('post_text', $post->post_content, $post);
    }

    return rest_ensure_response($post_data);
 }

 function custom_prepare_for_collection($response){
    if(!($response instanceof WP_REST_Response)){
        return $response;
    }

    $data = (array) $response->get_data();
    $links = rest_get_server()::get_compact_response_links($response);

    if(!empty($links)){
        $data['_links'] = $links;
    }

    return $data;
 }

 //function to ensure that only logged in users can access the endpoint
 function custom_endpoint_permission(){
    if(is_user_logged_in()){
        return true;
    } else {
        return false;
    }
 }

 //password encryption and decryption
 function encrypting_user_pwds(){
     //check if table exists
     global $wpdb;
     
     $table_name = $wpdb->prefix.'users_new';
     
     $new_user_tbl = "CREATE TABLE IF NOT EXISTS ".$table_name."(
         username text NOT NULL,
         useremail text NOT NULL,
         phone int NOT NULL,
         password text NOT NULL
        );";
        
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
        dbDelta($new_user_tbl);
        
    if (isset($_POST['btnSubmitUser'])){
        //hash password
        $pwd = $_POST['password'];
        $hashed_pwd = wp_hash_password($pwd);

        //store data
        $user_data = [
            'username' => $_POST['username'],
            'useremail' => $_POST['useremail'],
            'phone' => $_POST['phoneno'],
            'password' =>  $hashed_pwd
        ];

        // var_dump($user_data);
        $result = $wpdb->insert($table_name, $user_data);

        if($result){
            echo "<script> alert('User created successfully'); </script>";
        } else {
            echo "<script> alert('User not created'); </script>";
        }
    }
 }

 add_action('init', 'encrypting_user_pwds');

 //function to compare passwords
 function compare_password(){
    global $wpdb;

    $table_name = $wpdb->prefix.'users_new';

    //first get row data
    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE username = 'Mwaniki'");
    var_dump($result[0]->password);

    //then compare passwords
    $hashed_pwd = $result[0]->password;
    if (wp_check_password('12345', $hashed_pwd)){
        // var_dump('Passwords match');
    } else {
        // var_dump('Passwords do not match');
    }

    //many users authentication
    //$results = $wpdb->get_results("SELECT * FROM $table_name");

    // foreach($results as $result){
    //     $hashed_pwd = $result->password;
    //     if (wp_check_password('12345', $hashed_pwd)){
    //         var_dump('Passwords match');
    //     } else {
    //         var_dump('Passwords do not match');
    //     }
    // }
    
 }
 add_action('init', 'compare_password');
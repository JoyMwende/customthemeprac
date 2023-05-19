<?php

/**
 * @package Cohort13Pugin
 */

 /*
    Plugin Name: Cohort13 Plugin
    Plugin URI: http://...........
    Description: This is a plugin built by the jitu cohort 13 wordpress
    Version: 1.0.0
    Author: Cohort13
    AUthor URI: http://...........
    Licence: GPLv2 or Later
    Text Domain: cohort13-plugin
 */

 //security check
 defined('ABSPATH') or die('Security breaches identified');

if(file_exists(dirname(__FILE__).'/vendor/autoload.php')){
    require_once(dirname(__FILE__) . '/vendor/autoload.php');
}

use Inc\Activate;
use Inc\Deactivate;
class Cohort13{
    function __construct(){
        $this->plugin = plugin_basename(__FILE__);

        add_action('init', [$this, 'members_post_type']);
    }

    public function activate(){
        //require_once plugin_dir_path(__FILE__). 'inc/Activate.php';
        Activate::activate();
    }

    public function deactivate(){
        // require_once plugin_dir_path(__FILE__). 'inc/Deactivate.php';
        Deactivate::deactivate();
    }

    function members_post_type(){
    $labels=[
        'name'=>'Members',
        'singular_name'=>'Members',
        'add_new'=>'Add Members Item',
        'all_items'=>'All Members',
        'add_new_item'=>'Edit Item',
        'new_item'=>'New Item',
        'view_item'=>'View Item',
        'search_item'=>'Search Members',
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
            'menu_position'=> 6,
            'exclude_from_search'=>false
        ]
    ];

    register_post_type('members', $args);
    //Members is going to create the slug for permalink and $args is going to create the post type
}

public $plugin;

function registerPage(){
    add_action('add_menu', [$this, 'add_admin_page']);

    //settings link
    add_filter("plugin_action_links_$this->plugin", [$this, 'settings_link']);
}

function settings_link($links){
    $settingsLink = '<a href="admin.php?page=register_book">Register Book</a>';

    $links[] = $settingsLink;
    return $links;
}

function add_admin_page(){
    add_menu_page('Book Registration', 'Register Book', 'manage_options', 'register_book', [$this, 'admin_index_cb'], 'dasicon-welcome-write-blogs', 99);
}

function admin_index_cb(){
    require_once plugin_dir_path(__FILE__).'/templates/bookregister.php';
}

} 

if(class_exists('Cohort13')){
    $RegisterMembersInstance = new Cohort13();
}

// register_activation_hook(__FILE__, [$RegisterMembersInstance, 'activate']);
// register_deactivation_hook(__FILE__, [$RegisterMembersInstance, 'deactivate']);

$RegisterMembersInstance->activate();
$RegisterMembersInstance->deactivate();
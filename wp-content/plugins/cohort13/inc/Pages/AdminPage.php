<?php

/**
 * @package Cohort13Plugin
 */

namespace Inc\Pages;

use \Inc\Base\BaseController;
use \Inc\Api\SettingsApi;

class AdminPage extends BaseController{

    public $settings;

    public $pages;
    public $subpages;

    public function __construct(){
        $this->settings = new SettingsApi();
        
    $this->pages= [
        [
            'page_title'=> 'Books Menu',
            'menu_title'=> 'Book Menu',
            'capability' => 'manage_options',
            'menu_slug'=> 'books_menu',
            'callback'=> function(){
                echo '<h1> Cohort 13 Books Menu </h1>';
            },
            'icon_url'=> 'dashicons-welcome-write-blog',
            'position'=> 110
        ]
    ];

    $this->subpages =[
        [
            'parent_slug'=> 'books_menu',
            'page_title' => 'Register books',
            'menu_title' => 'Register Books',
            'capability' => 'manage_options',
            'menu_slug' => 'register_books',
            'callback' => function() {
                echo '<h1> Register Books </h1>';
            }
        ],
        [
            'parent_slug'=> 'books_menu',
            'page_title' => 'Update BOOK',
            'menu_title' => 'Update BOOK',
            'capability' => 'manage_options',
            'menu_slug' => 'update_books',
            'callback' => function() {
                echo '<h1> Update Book </h1>';
            }
        ],
        [
            'parent_slug'=> 'books_menu',
            'page_title' => 'View Authors',
            'menu_title' => 'View Authors',
            'capability' => 'manage_options',
            'menu_slug' => 'view_authors',
            'callback' => function() {
                echo '<h1> View Authors of the different Books </h1>';
            }
        ]
    ];
    }

    function register(){
        // add_action('admin_menu', [$this, 'add_admin_page']);
        $this->settings->AddPages( $this->pages )->HasSubPage('View Books')->addSubPages($this->subpages)->register();
    }


    // function add_admin_page(){
    //     add_menu_page('Book Registration', 'Register Book', 'manage_options', 'register_book', [$this, 'admin_index_cb'], 'dashicons-welcome-write-blog', 110);
    // }

    // function admin_index_cb(){
    //     require_once $this->plugin_path.'templates/bookregister.php';  
    // }
}

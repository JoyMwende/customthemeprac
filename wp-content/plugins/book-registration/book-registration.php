<?php

/**
 * @package TicketPlugin
 */



/*
    Plugin Name: Book Registration
    Plugin URI: http://...........
    Description: This is a plugin to register books
    Version: 1.0.0
    Author: Joy
    AUthor URI: http://...........
    Licence: GPLv2 or Later
    Text Domain: book-registration-plugin
  */

//security check
defined('ABSPATH') or die('Hey you hacker! Got ya!');

class BookReg{
    function __construct(){
      $this->add_book_to_db();
    }

//activate method
    function activateExternally(){
        require_once plugin_dir_path(__FILE__) . 'Inc/book-registration-activate.php';
        BookRegActivate::activatePlugin();
    }


//deactivate method
    function deactivateExternally()
    {
        require_once plugin_dir_path(__FILE__) . 'Inc/book-registration-deactivate.php';
        BookRegDeactivate::deactivatePlugin();
    }

    static function create_table_to_db(){
        global $wpdb;

        $table_name = $wpdb->prefix. 'books';

        $book_details = "CREATE TABLE IF NOT EXISTS ".$table_name."(
            title text NOT NULL,
            author text NOT NULL,
            publisher text NOT NULL
        );";

        require_once(ABSPATH. 'wp-admin/includes/upgrade.php');
        dbDelta($book_details);
    }

    function add_book_to_db(){
        if (isset($_POST['submitbtn'])){
            $data = [
                'title' => $_POST['title'],
                'author' => $_POST['author'],
                'publisher' => $_POST['publisher']
            ];

            global $wpdb;
            global $successmessage;
            global $errormessage;

            $successmessage = false;
            $errormessage = false;

            $table_name = $wpdb->prefix.'books';

            $result = $wpdb->insert($table_name, $data, $format = NULL);

            if ($result == true){
                $successmessage = true;
                // echo "<script> alert('Book Registered Successfully');</script>";
            } else {
                $errormessage = true;
                // echo "<script> alert('Unable to Register');</script>";
            }
        }
    }
}

if(class_exists('BookReg')){
    $bookRegInstance = new BookReg();
}

// register_activation_hook(__FILE__, array($bookRegInstance, 'activateExternally'));
$bookRegInstance->activateExternally();

// register_deactivation_hook(__FILE__, array($bookRegInstance, 'deactivateExternally'));
$bookRegInstance->deactivateExternally();

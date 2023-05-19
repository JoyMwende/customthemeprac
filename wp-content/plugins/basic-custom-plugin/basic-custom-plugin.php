<?php

/**
 * @package: Custom Plugin
 */

/*
  Plugin Name: Basic Custom Plugin
  Plugin URI: http://............
  Description: This is the first plugin
  Version: 1.0.0
  Author: Joy
  Author URI: http://joy/...........
  Licence: GPLv2 or Later
  Text Domain: custom plugin
  */

//security check
//method 1
if (!defined('ABSPATH')) {
    die; //or exit;
}

//method 2
defined('ABSPATH') or die("Hey you hacker, got you!");

//method 3
if (!function_exists('add_action')) {
    echo 'Got you';
    exit;
}

class CustomPlugin
{
    function __construct()
    {
        echo "Action triggered";
    }

    //check if actions were triggered by wordpress
    //activation method
    function activate()
    {
        echo "Plugin Activated";
        flush_rewrite_rules();
    }
}

if (class_exists('CustomPlugin')) {
    $customPluginInstance = new CustomPlugin();
}

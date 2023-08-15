<?php
/*
Plugin Name: Lucky Draw Plugin
Description: A simple plugin to show a div and a heading with two different options.
Version: 1.0
Author: Your Name
Author URI: Your Website
*/



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once plugin_dir_path(__FILE__) . 'includes/enqueue-scripts.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin-settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';
require_once plugin_dir_path(__FILE__) . 'includes/content-filtering.php';

// Your main plugin file
require_once plugin_dir_path(__FILE__) . 'includes/create-table.php';
// Your main plugin file
register_activation_hook(__FILE__, 'lucky_draw_activate');

function lucky_draw_activate() {
    // Enable error logging for debugging during activation
    lucky_draw_create_table();
}





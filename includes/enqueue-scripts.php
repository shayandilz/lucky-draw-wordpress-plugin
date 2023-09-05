<?php

// Enqueue the media library script
function lucky_draw_enqueue_media_script()
{
    if (isset($_GET['page']) && $_GET['page'] === 'lucky_draw_settings') {
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_media();
        wp_enqueue_script('lucky-draw-media', plugin_dir_url(__FILE__) . '../assets/script.js', array('jquery'), '1.0', true);
    }
}

add_action('admin_enqueue_scripts', 'lucky_draw_enqueue_media_script');
// Enqueue the main CSS file
function lucky_draw_enqueue_scripts()
{

    wp_enqueue_style('lucky-draw-style', plugin_dir_url(__FILE__) . '../assets/style.css');
    wp_enqueue_style('bootstrap-css', plugin_dir_url(__FILE__) . '../assets/bootstrap/bootstrap.min.css');
    wp_enqueue_script('bootstrap-bundle', plugin_dir_url(__FILE__) . '../assets/bootstrap/bootstrap.bundle.min.js');
    $current_option = get_option('lucky_draw_option', 'option1');

    if ($current_option === 'option1') {
        wp_enqueue_style('option1-style', plugin_dir_url(__FILE__) . '../assets/wheel/style.css', array(), '1.0');
        wp_enqueue_script('option1-script', plugin_dir_url(__FILE__) . '../assets/wheel/script.mjs', array('jquery'), '1.0', true);
        // Localize the script and pass the values to option1.js
        $option1_data = array(
            'inputValue' => get_option('option1_input_value', ''),
            'acfNumberValue' => get_option('option1_acf_number_value', ''),
            'site_url' => get_site_url(),
            'username' => 'sh.dilmaghani',
            'password' => '6yS7 82gj qdOW 4PpR ONX3 HIa7'
        );
        wp_localize_script('option1-script', 'option1_data', $option1_data);
    } elseif ($current_option === 'option2') {
        wp_enqueue_style('option2-style', plugin_dir_url(__FILE__) . '../assets/roulette/style.css', array(), '1.0');
        wp_enqueue_script('option2-script', plugin_dir_url(__FILE__) . '../assets/roulette/script.js', array('jquery'), '1.0', true);

        // Retrieve option2_repeater values from the plugin's saved data
        $option2_repeater = get_option('option2_repeater', array());

        // Localize the script and pass the values to script.js
        wp_localize_script('option2-script', 'option2RepeaterData', $option2_repeater);
    }
}

add_action('wp_enqueue_scripts', 'lucky_draw_enqueue_scripts');
<?php

// Shortcode handler for Option 1
function lucky_draw_option1_shortcode()
{
    ob_start();
    include plugin_dir_path(__FILE__) . '../templates/wheel.php';
    return ob_get_clean();
}

add_shortcode('lucky_draw_option1', 'lucky_draw_option1_shortcode');

// Shortcode handler for Option 2
function lucky_draw_option2_shortcode()
{
    ob_start();
    include plugin_dir_path(__FILE__) . '../templates/roulette.php';
    return ob_get_clean();
}

add_shortcode('lucky_draw_option2', 'lucky_draw_option2_shortcode');

// Shortcode handler for displaying the selected option's content
function lucky_draw_shortcode()
{
    $current_option = get_option('lucky_draw_option', 'option1');

    // Check the current selected option and return the corresponding shortcode
    if ($current_option === 'option1') {
        return '[lucky_draw_option1]';
    } elseif ($current_option === 'option2') {
        return '[lucky_draw_option2]';
    }
}

add_shortcode('lucky_draw', 'lucky_draw_shortcode');

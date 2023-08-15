<?php


// Filter to modify the "luckyDraw" page content based on the chosen option
function lucky_draw_modify_page_content($content)
{
    // Check if it's the "luckyDraw" page
    if (is_page_template('wheel.php')) {
        // Get the selected option's content using the shortcode
        $selected_content = do_shortcode('[lucky_draw]');

        // Replace the page content with the selected content
        $content = $selected_content;
    }

    return $content;
}

add_filter('the_content', 'lucky_draw_modify_page_content');
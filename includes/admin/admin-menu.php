<?php
// Create the admin settings page
function lucky_draw_add_admin_menu()
{
    add_menu_page(
        'Lucky Draw Settings',          // Page title
        'Lucky Draw',                   // Menu title
        'manage_options',               // Capability required to access the menu
        'lucky_draw_settings',          // Menu slug
        'lucky_draw_settings_page',     // Callback function to render the page
        'dashicons-tickets',            // Icon for the menu
        99                              // Menu position
    );
}

add_action('admin_menu', 'lucky_draw_add_admin_menu');

// Add a new submenu page for previewing imported data
function lucky_draw_winner_page()
{
    add_submenu_page(
        'lucky_draw_settings',
        'Lucky Draw Winners',
        'Lucky Draw Winners',
        'manage_options',
        'lucky_draw_winner',
        'lucky_draw_winner_preview_page'
    );
}

add_action('admin_menu', 'lucky_draw_winner_page');
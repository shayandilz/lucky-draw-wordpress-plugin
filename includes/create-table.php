<?php
// create-table.php
function lucky_draw_create_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'lucky_draw_entries';
    error_log('Creating table: ' . $table_name);

    // Check if the table already exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            entry_id varchar(20) NOT NULL,
            phone_number varchar(20) NOT NULL,
            campaign_prize varchar(255) NOT NULL,
            brand VARCHAR(255) NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}


function lucky_draw_register_api_endpoint()
{
    // Add POST endpoint
    register_rest_route('lucky-draw/v1', '/add-entry', array(
        'methods' => 'POST',
        'callback' => 'lucky_draw_add_entry',
    ));
    // Add GET endpoint
    register_rest_route('lucky-draw/v1', '/get-entries', array(
        'methods' => 'GET',
        'callback' => 'lucky_draw_get_entries',
    ));
    // Add DELETE endpoint for deleting the entire table
    register_rest_route('lucky-draw/v1', '/delete-all-entries', array(
        'methods' => 'DELETE',
        'callback' => 'lucky_draw_delete_all_entries',
    ));
}

add_action('rest_api_init', 'lucky_draw_register_api_endpoint');


function lucky_draw_delete_all_entries()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'lucky_draw_entries';

    $wpdb->query("TRUNCATE TABLE $table_name");

    echo "Table deleted.";
}

function lucky_draw_get_entries()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'lucky_draw_entries';

    $query = "SELECT * FROM $table_name";
    $entries = $wpdb->get_results($query);

    return new WP_REST_Response($entries, 200);
}


function lucky_draw_add_entry(WP_REST_Request $request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'lucky_draw_entries';

    $data = $request->get_params();
    $entries = $data;

    foreach ($entries as $entry) {
        $entry_id = intval($entry['entry_id']);
        $phone_number = $wpdb->prepare('%s', $entry['phone_number']);
        $campaign_prize = $wpdb->prepare('%s', $entry['campaign_prize']);
        $brand = $wpdb->prepare('%s', $entry['brand']);

        $wpdb->insert($table_name, array(
            'entry_id' => $entry_id,
            'phone_number' => $phone_number,
            'campaign_prize' => $campaign_prize,
            'brand' => $brand,
        ));
    }

    return new WP_REST_Response(array('message' => 'Entry added.'), 200);
}


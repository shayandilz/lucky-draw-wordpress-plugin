<?php


require_once 'admin/admin-menu.php';
require_once 'admin/lucky-draw-settings.php';
require_once 'admin/roulette-settings.php';
require_once 'admin/lucky-draw-winners.php';


// Callback function to render the admin settings page
function lucky_draw_settings_page()
{

    $current_option = get_option('lucky_draw_option', 'option1');
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="py-3 mb-3 ">
                    <h1 class="fw-bolder">Prize Events</h1>
                    <p class="fs-4">Choose the Prize Event</p>
                </div>
                <form method="post" class="container">
                    <div class="row">
                        <div class="col-9">
                            <?php
                            if ($current_option === 'option1') {
                                lucky_draw_settings_option1();
                            } elseif ($current_option === 'option2') {
                                lucky_draw_settings_option2();
                            }
                            ?>
                        </div>
                        <div class="col-3">
                            <div class="border border-1 border-dark border-opacity-25 bg-light pb-3 rounded-2">
                                <div class="d-flex justify-content-center align-items-center flex-column border-bottom border-1 border-warning border-opacity-75 py-3 bg-warning bg-opacity-25 rounded-2">
                                    <div class="d-inline-flex gap-4 mb-4 ">
                                        <div class="form-check d-inline-flex align-items-center">
                                            <input id="inlineRadio1" class="form-check-input" type="radio"
                                                   name="lucky_draw_option"
                                                   value="option1" <?php checked('option1', $current_option); ?> />
                                            <label class="form-check-label" for="inlineRadio1">Lucky Draw</label>
                                        </div>
                                        <div class="form-check d-inline-flex align-items-center">
                                            <input id="inlineRadio2" class="form-check-input" type="radio" name="lucky_draw_option"
                                                   value="option2" <?php checked('option2', $current_option); ?> />
                                            <label class="form-check-label" for="inlineRadio2">Roulette</label>
                                        </div>
                                    </div>
                                    <input type="submit" name="lucky_draw_switch" value="Click To Change" class="btn-primary btn"/>
                                </div>
                                <div class="pt-4">
                                    <input type="submit" name="lucky_draw_save" value="Save Setting" class="btn btn-success"/>
                                </div>
                            </div>

                        </div>
                    </div>



                </form>
            </div>

        </div>
    </div>
    <?php
}

// Save the options data
function lucky_draw_save_settings()
{
    if (isset($_POST['lucky_draw_switch'])) {
        // Switch the option without saving any data
        $selected_option = $_POST['lucky_draw_option'];
        update_option('lucky_draw_option', $selected_option);
    } elseif (isset($_POST['lucky_draw_save'])) {
        // Save the submitted data for the selected option
        $selected_option = $_POST['lucky_draw_option'];
        update_option('lucky_draw_option', $selected_option);

        if ($selected_option === 'option1') {
            update_option('option1_input_value', sanitize_text_field($_POST['option1_input']));
            update_option('option1_acf_number_value', absint($_POST['option1_acf_number']));
            update_option('option1_custom_text_value', sanitize_text_field($_POST['option1_custom_text']));
            update_option('option1_custom_image_id', absint($_POST['option1_custom_image_id']));
            update_option('option1_custom_color_value', sanitize_hex_color($_POST['option1_custom_color'])); // Save the color value
            update_option('option1_custom_text_another_value', sanitize_text_field($_POST['option1_custom_text_another']));
            update_option('option1_custom_image_another_id', absint($_POST['option1_custom_image_another_id'])); // Save the image ID for the new field
        } elseif ($selected_option === 'option2') {

            $repeater_texts = isset($_POST['option2_repeater_text']) ? array_map('sanitize_text_field', $_POST['option2_repeater_text']) : array();
            $repeater_image_ids = isset($_POST['option2_repeater_image_id']) ? array_map('absint', $_POST['option2_repeater_image_id']) : array();
            $repeater_colors = isset($_POST['option2_repeater_color']) ? array_map('sanitize_hex_color', $_POST['option2_repeater_color']) : array();

            $option2_repeater = array();
            foreach ($repeater_texts as $key => $text) {
                $image_id = isset($repeater_image_ids[$key]) ? $repeater_image_ids[$key] : 0;
                $color = isset($repeater_colors[$key]) ? $repeater_colors[$key] : '';

                // Get the image URL based on the image ID
                $image_url = '';
                if ($image_id) {
                    $image_url = wp_get_attachment_image_src($image_id, 'full')[0];
                }

                $option2_repeater[] = array(
                    'text' => $text,
                    'image_id' => $image_id,
                    'image_url' => $image_url, // Add image URL to the array
                    'color' => $color
                );
            }
            update_option('option2_repeater', $option2_repeater);

        }
    }
}

add_action('admin_init', 'lucky_draw_save_settings');
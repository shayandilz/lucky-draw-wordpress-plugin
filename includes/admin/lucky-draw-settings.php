<?php

// Callback function to render the settings for Option 1
function lucky_draw_settings_option1()
{
    $option1_input_value = get_option('option1_input_value', '');
    $option1_acf_number_value = get_option('option1_acf_number_value', '');
    $option1_custom_text_value = get_option('option1_custom_text_value', '');
    $option1_custom_image_id = get_option('option1_custom_image_id', ''); // New custom image field value
    $option1_custom_color_value = get_option('option1_custom_color_value', ''); // New color field value
    $option1_custom_text_another_value = get_option('option1_custom_text_another_value', '');
    $option1_custom_image_another_id = get_option('option1_custom_image_another_id', '');

    ?>
    <div class="container">
        <div class="row border border-1 border-dark border-opacity-25 bg-light p-4 rounded-2">
            <div class="col-12">
                <div class="row g-3 mb-4 border-bottom border-1 border-dark border-opacity-25 pb-4">
                    <div class="col">
                        <label class="form-label fw-bold">API URL</label>
                        <input type="text" class="form-control" name="option1_input" placeholder="Choose Title"
                               value="<?php echo esc_attr($option1_input_value); ?>"/>
                    </div>
                </div>
                <div class="row g-3 mb-4 border-bottom border-1 border-dark border-opacity-25 pb-4">
                    <div class="col">
                        <label class="form-label">Number of Winners</label>
                        <input type="number" class="form-control" name="option1_acf_number"
                               placeholder="Number of Winners"
                               value="<?php echo esc_attr($option1_acf_number_value); ?>"/>
                    </div>
                    <div class="col">
                        <label class="form-label">Brands Name</label>
                        <input type="text" name="option1_custom_text" class="form-control" placeholder="Brands Name"
                               value="<?php echo esc_attr($option1_custom_text_value); ?>"/>
                    </div>
                    <div class="col">
                        <label class="form-label">Prize Name</label>
                        <input type="text" name="option1_custom_text_another" class="form-control"
                               value="<?php echo esc_attr($option1_custom_text_another_value); ?>"/>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col">
                        <label class="form-label">Background Color</label>
                        <input type="text" name="option1_custom_color" class="option1-color-picker"
                               value="<?php echo esc_attr($option1_custom_color_value); ?>"/>
                    </div>
                    <div class="col">
                        <label class="form-label">Brand Image</label>
                        <input type="hidden" name="option1_custom_image_id" class="form-control"
                               id="option1_custom_image_id"
                               value="<?php echo esc_attr($option1_custom_image_id); ?>"/>
                        <div class="d-flex flex-column justify-content-start">
                            <?php if ($option1_custom_image_id) { ?>
                                <img src="<?php echo wp_get_attachment_image_src($option1_custom_image_id, 'thumbnail')[0]; ?>"
                                     id="option1_custom_image_preview" class="bg-danger bg-opacity-25 p-4"
                                     style="max-width: 300px; display: block;">
                            <?php } ?>
                            <button type="button" class="btn btn-secondary fs-6 mt-2" id="option1_custom_image_button">
                                Select Image
                            </button>
                            <?php if ($option1_custom_image_id) { ?>
                                <button type="button" class="btn btn-danger fs-6 mt-2"
                                        id="option1_custom_image_delete_button">
                                    Delete Image
                                </button>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col">
                        <input type="hidden" name="option1_custom_image_another_id" id="option1_custom_image_another_id"
                               value="<?php echo esc_attr($option1_custom_image_another_id); ?>"/>
                        <label class="form-label">Background Image</label>
                        <div class="d-flex flex-column justify-content-start">
                            <?php if ($option1_custom_image_another_id) { ?>
                                <img src="<?php echo wp_get_attachment_image_src($option1_custom_image_another_id, 'thumbnail')[0]; ?>"
                                     id="option1_custom_image_another_preview"
                                     style="max-width: 400px; <?php echo $option1_custom_image_another_id ? 'display: block;' : 'display: none;'; ?>">
                            <?php } ?>
                            <button type="button" class="btn btn-secondary fs-6 mt-2"
                                    id="option1_custom_image_another_button">Select Image
                            </button>
                            <?php if ($option1_custom_image_another_id) { ?>
                                <button type="button" class="btn btn-danger fs-6 mt-2"
                                        id="option1_custom_image_another_delete_button">
                                    Delete Image
                                </button>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <?php
}
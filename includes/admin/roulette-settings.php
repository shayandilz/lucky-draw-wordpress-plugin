<?php
function lucky_draw_settings_option2()
{
    $option2_input_value = get_option('option2_input_value', '');

    $option2_repeater = get_option('option2_repeater', array()); // Get the repeater field values

    ?>
    <!--    <p>Enter a value for Option 2:</p>-->
    <!--    <input type="text" name="option2_input" value="--><?php //echo esc_attr($option2_input_value); ?><!--"/><br><br>-->

    <!-- Repeater Field -->
    <div id="option2_repeater_container container">
        <div class="row g-4 border border-1 border-dark border-opacity-25 bg-light p-4 rounded-2 mt-0">
            <?php if ($option2_repeater) { ?>
                <?php foreach ($option2_repeater as $repeater_item) : ?>
                    <div class="repeater-item d-flex justify-content-between gap-5 align-items-center border-bottom border-1 border-dark border-opacity-25 pb-4">
                        <div class="d-flex g-3 flex-column align-items-start justify-content-start bg-warning bg-opacity-25 p-3 rounded-2 h-100">
                            <label for="prize_item" class="form-label">Prize Title</label>
                            <input type="text" name="option2_repeater_text[]" id="prize_item" class="form-control"
                                   value="<?php echo esc_attr($repeater_item['text']); ?>" placeholder="Prize Title"/>
                        </div>
                        <div class="d-flex g-3 flex-column align-items-center justify-content-center bg-warning bg-opacity-25 p-3 rounded-2 h-100">
                            <label for="prize_image" class="form-label">Prize Image</label>
                            <input type="hidden" name="option2_repeater_image_id[]" id="prize_image"
                                   value="<?php echo esc_attr($repeater_item['image_id']); ?>"/>
                            <div class="repeater-image-preview">
                                <?php if ($repeater_item['image_id']) {
                                    echo wp_get_attachment_image($repeater_item['image_id'], 'thumbnail');
                                } ?>
                            </div>
                            <button class="upload-repeater-image mt-3 fs-6 btn btn-primary">Select Image</button>
                        </div>
                        <div class="d-flex g-3 flex-column align-items-center justify-content-center bg-warning bg-opacity-25 p-3 rounded-2 h-100">
                            <label for="prize_color" class="form-label">Prize Section Color</label>
                            <input type="color" id="prize_color" name="option2_repeater_color[]" value="<?php echo esc_attr($repeater_item['color']); ?>"/>
                        </div>
                        <button class="remove-repeater-item btn btn-danger">Remove</button>
                    </div>
                <?php endforeach; ?>
            <?php } ?>
        </div>
    </div>

    <div id="repeater-items-container"></div>

    <button id="add-repeater-item" class="btn btn-success mt-4">Add New Prize</button>
    <script>
        jQuery(document).ready(function ($) {
            $(document).on('input', '.repeater-color-picker', function () {
                $(this).siblings('.repeater-color-preview').css('background-color', $(this).val());
            });
            $('#add-repeater-item').click(function (e) {
                e.preventDefault();
                $('#repeater-items-container').append(
                    '<div class="repeater-item bg-success bg-opacity-25 d-flex justify-content-center gap-5 align-items-center py-3 my-4">' +
                    '<div class="d-flex g-3 flex-column align-items-start justify-content-start p-3 h-100">' +
                    '<label for="prize_item" class="form-label">Prize Title</label>' +
                    '<input type="text" name="option2_repeater_text[]" placeholder="Prize Title"/>' +
                    '</div>' +
                    '<div class="d-flex g-3 flex-column align-items-center justify-content-center p-3 h-100">' +
                    '<label for="prize_image" class="form-label">Prize Image</label>' +
                    '<input type="hidden" name="option2_repeater_image_id[]" class="repeater-image-id" value="0"/>' +
                    '<div class="repeater-image-preview"></div>' +
                    '<button class="upload-repeater-image mt-3 fs-6 btn btn-primary">Select Image</button>' +
                    '</div>' +
                    '<div class="d-flex g-3 flex-column align-items-center justify-content-center p-3 h-100">' +
                    '<label for="prize_color" class="form-label">Prize Section Color</label>' +
                    '<input type="color" name="option2_repeater_color[]" class="repeater-color-picker" value="#ffffff"/>' +
                    '<div class="repeater-color-preview"></div>' +
                    '</div>' +
                    '<button class="remove-repeater-item btn btn-danger">Remove</button>' +
                    '</div>'
                );
            });

            $(document).on('click', '.remove-repeater-item', function () {
                $(this).parent('.repeater-item').remove();
            });

            $(document).on('click', '.upload-repeater-image', function (e) {
                e.preventDefault();

                var button = $(this);
                var imageField = button.siblings('[name="option2_repeater_image_id[]"]');
                var previewField = button.siblings('.repeater-image-preview');

                var file_frame = wp.media.frames.file_frame = wp.media({
                    title: 'Select Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });

                file_frame.on('select', function () {
                    var attachment = file_frame.state().get('selection').first().toJSON();
                    imageField.val(attachment.id);
                    previewField.html('<img src="' + attachment.url + '" style="max-width: 100px;" />');
                });

                file_frame.open();
            });

        });
    </script>
    <?php
}
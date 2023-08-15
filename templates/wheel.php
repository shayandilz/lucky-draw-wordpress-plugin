<?php
$option1_custom_color_value = get_option('option1_custom_color_value', ''); // Retrieve the custom color value
$option1_custom_image_another_id = get_option('option1_custom_image_another_id', '');
$option1_custom_text_another_value = get_option('option1_custom_text_another_value', '');
?>
<section class="h-100 w-100 position-relative overflow-x-hidden overflow-y-hidden landing"
         style="background-color: <?php echo esc_attr($option1_custom_color_value); ?>; background-image: url('<?php echo $option1_custom_image_another_id ? wp_get_attachment_image_src($option1_custom_image_another_id, 'thumbnail')[0] : '' ?>'); background-size: cover; background-position: center center; background-repeat: no-repeat">
    <div class="container d-flex align-items-center justify-content-between  min-vh-100">
        <div class="row px-0  justify-content-center align-items-center w-100">
            <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center gap-5 py-3 px-3 z-top"
                 style="background-image: url('https://summer.xvision.ir/wp-content/uploads/2023/07/stars.png'); background-size: cover;background-position: center center; background-repeat: no-repeat">
                <!-- Display the Title -->
                <?php $option1_custom_text_value = get_option('option1_custom_text_value', ''); ?>
                <h1 class="text-white mb-4 brandTitle"
                    data-title-brand="<?php echo esc_html($option1_custom_text_value); ?>">
                    <?php echo esc_html($option1_custom_text_value); ?>
                </h1>
                <!-- Display the Logo image -->
                <?php $option1_custom_image_id = get_option('option1_custom_image_id', ''); ?>
                <?php if (!empty($option1_custom_image_id)) : ?>
                    <?php echo wp_get_attachment_image($option1_custom_image_id, 'thumbnail'); ?>
                <?php endif; ?>


                <form class="text-center">
                    <fieldset name='number-code' data-number-code-form>
                        <legend>Number Code</legend>
                        <input type="number" min='0' max='9' name='number-code-0' class="pt-3"
                               data-number-code-input='0'
                               required/>
                        <input type="number" min='0' max='9' name='number-code-1' class="pt-3"
                               data-number-code-input='1'
                               required/>
                        <input type="number" min='0' max='9' name='number-code-2' class="pt-3"
                               data-number-code-input='2'
                               required/>
                        <input type="number" min='0' max='9' name='number-code-3' class="pt-3"
                               data-number-code-input='3'
                               required/>
                    </fieldset>
                </form>

                <button type="button" class="swipe-overlay-out border-0 fs-4 px-4 py-2 mt-2 fw-bold"
                        data-fetch-button>
                    انتخاب برنده
                </button>

            </div>
            <div class="col-lg-6 z-top" id="winnerContainer">
                <table id="phoneNumbersContainer" class="w-100 align-middle">
                    <thead>
                    <tr>
                        <th><h2 class="display-3 text-white text-center fw-bold prizeTitle"
                                data-title-prize="<?php echo esc_html($option1_custom_text_another_value); ?>"><?php echo esc_html($option1_custom_text_another_value); ?></h2>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="row row-cols-lg-2 justify-content-center align-items-center gap-4">
                    </tbody>
                </table>
                <div class="d-flex gap-3 flex-wrap justify-content-center mt-4">
                    <button class="btn text-bg-success bg-danger text-white uploadButton pt-3 fs-5" data-upload-button>
                        Submit the Winners
                    </button>
                </div>

            </div>
        </div>
    </div>
</section>
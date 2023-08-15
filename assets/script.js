jQuery(document).ready(function($) {
    // Function to handle image deletion
    function handleImageDeletion(imageField, imagePreview) {
        imageField.val('');
        imagePreview.attr('src', '').css('display', 'none');
    }

    $('#option1_custom_image_button').click(function(e) {
        e.preventDefault();

        var customImageField = $('#option1_custom_image_id');
        var customImagePreview = $('#option1_custom_image_preview');

        var mediaUploader = wp.media({
            title: 'Select Custom Image',
            button: {
                text: 'Use this image'
            },
            library: {
                type: 'image'
            },
            multiple: false
        });

        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            customImageField.val(attachment.id);
            customImagePreview.attr('src', attachment.sizes.thumbnail.url).css('display', 'block');
        });

        mediaUploader.open();
    });

    // Add the functionality to delete the custom image
    $('#option1_custom_image_delete_button').click(function(e) {
        e.preventDefault();

        var customImageField = $('#option1_custom_image_id');
        var customImagePreview = $('#option1_custom_image_preview');

        handleImageDeletion(customImageField, customImagePreview);
    });

    // Show the selected image preview immediately after loading the page
    var customImageField = $('#option1_custom_image_id');
    var customImagePreview = $('#option1_custom_image_preview');
    var customImageID = customImageField.val();
    if (customImageID) {
        var attachment = wp.media.attachment(customImageID);
        attachment.fetch();
        // customImagePreview.attr('src', attachment.get('sizes').thumbnail.url).css('display', 'block');
    }

    // Add the functionality for the new image field
    $('#option1_custom_image_another_button').click(function(e) {
        e.preventDefault();

        var customImageField = $('#option1_custom_image_another_id');
        var customImagePreview = $('#option1_custom_image_another_preview');

        var mediaUploader = wp.media({
            title: 'Select Another Custom Image',
            button: {
                text: 'Use this image'
            },
            library: {
                type: 'image'
            },
            multiple: false
        });

        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            customImageField.val(attachment.id);
            customImagePreview.attr('src', attachment.sizes.thumbnail.url).css('display', 'block');
        });

        mediaUploader.open();
    });

    // Add the functionality to delete the another custom image
    $('#option1_custom_image_another_delete_button').click(function(e) {
        e.preventDefault();

        var customImageField = $('#option1_custom_image_another_id');
        var customImagePreview = $('#option1_custom_image_another_preview');

        handleImageDeletion(customImageField, customImagePreview);
    });

    $('.option1-color-picker').wpColorPicker();

});



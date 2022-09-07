jQuery(document).ready(function ($) {
    // Set all variables to be used in scope
    let frame,
        metaBox = $('#wcpr-comment-photos'), // Your meta box id here
        addImgLink = metaBox.find('.wcpr-upload-custom-img'),
        imgContainer = metaBox.find('#wcpr-new-image');

    // ADD IMAGE LINK
    addImgLink.on('click', function (event) {
        event.preventDefault();

        // If the media frame already exists, reopen it.
        if (frame) {
            frame.open();
            return;
        }

        // Create a new media frame
        frame = wp.media({
            title: 'Select or Upload Media Of Your Chosen Persuasion',
            button: {
                text: 'Use this media'
            },
            multiple: true  // Set to true to allow multiple files to be selected
        });


        // When an image is selected in the media frame...
        frame.on('select', function () {

            // Get media attachment details from the frame state
            let attachment = frame.state().get('selection').toJSON();
            let attachment_url;
            if(attachment.length>0){
                for(let i=0;i<attachment.length;i++) {
                    if (attachment[i].sizes.thumbnail) {
                        attachment_url = attachment[i].sizes.thumbnail.url;
                    } else if (attachment[i].sizes.medium) {
                        attachment_url = attachment[i].sizes.medium.url;
                    } else if (attachment[i].sizes.large) {
                        attachment_url = attachment[i].sizes.large.url;
                    } else if (attachment[i].url) {
                        attachment_url = attachment[i].url;
                    }
                    // Send the attachment[i] URL to our custom image input field.
                    imgContainer.append('<div class="wcpr-review-image-container"><a href="' + attachment_url + '" data-lightbox="photo-reviews-' + $('#comment_ID').val() + '" data-img_post_id="' + attachment[i].id + '"><img style="border: 1px solid;" class="review-images" src="' + attachment_url + '"/></a><input class="photo-reviews-id" name="photo-reviews-id[]" type="hidden" value="' + attachment[i].id + '"/><a href="#" class="wcpr-remove-image">Remove</a></div>');
                }
            }
        });

        // Finally, open the modal on click
        frame.open();
    });
    // DELETE IMAGE LINK

    $('body').on('click','.wcpr-remove-image', function (event) {
        event.preventDefault();
        $(this).parent().remove();
    })

});
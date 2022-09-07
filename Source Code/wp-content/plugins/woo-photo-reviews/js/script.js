jQuery(document).ready(function ($) {
    let comments = woocommerce_photo_reviews_params.hasOwnProperty('comments_container_id') ? woocommerce_photo_reviews_params.comments_container_id : 'comments';
    $('#' + comments).prepend($('.wcpr-filter-container')).prepend($('.wcpr-overall-rating-and-rating-count')).prepend($('.woocommerce-Reviews-title').eq(0));
    let max_files = woocommerce_photo_reviews_params.max_files;
    function getSelectedImageHtml(src, name, error='') {
        let selectImageHtml;
        let temp =`<img title="${name}" src="${src}" class="wcpr-selected-image-preview">`;
        if (error){
            selectImageHtml = `<div class="wcpr-selected-image">${temp}<div class="wcpr-selected-image-info"><div class="wcpr-selected-image-name wcpr-comment-form-error" >${error}</div></div></div>`;
        }else {
            selectImageHtml = `<div class="wcpr-selected-image">${temp}<div class="wcpr-selected-image-info"><div class="wcpr-selected-image-name" title="${name}">${name}</div></div></div>`;
        }
        return selectImageHtml;
    }
    function readURL(input) {
        let max_file_size = 1024 * parseFloat(woocommerce_photo_reviews_params.max_file_size);
        for (let i = 0; i < input.files.length; i++) {
            var reader = new FileReader();

            reader.onload = function (e) {
                let error ='';
                if (woocommerce_photo_reviews_params.upload_allow.indexOf(input.files[i].type) === -1){
                    error=woocommerce_photo_reviews_params.warning_upload_allow.replace('%file_name%',input.files[i].name);
                }else if (input.files[i].size > max_file_size){
                    error= woocommerce_photo_reviews_params.warning_max_file_size.replace('%file_name%',input.files[i].name);
                }
                $(input).parent().find('.wcpr-selected-image-container').append(getSelectedImageHtml(e.target.result, input.files[i].name, error))
            };

            reader.readAsDataURL(input.files[i]); // convert to base64 string
        }
    }
    $('#commentform').on('change', '.wcpr_image_upload', function (e) {
        $(this).parent().find('.wcpr-selected-image-container').html('');
        if (this.files.length > max_files) {
            alert(woocommerce_photo_reviews_params.warning_max_files);
            $(this).val('');
            return false;
        } else if (this.files.length > 0) {
            readURL(this);
        }
    });
    $('#commentform').find('input[type="submit"]').on('click', function (e) {
        let $container = $(this).closest('form');
        let $content = $container.find('textarea[id="comment"]')||$container.find('textarea[name="comment"]');
        let $name = $container.find('input[name="author"]');
        let $email = $container.find('input[name="email"]');
        if ($content.length > 0 && !$content.val()) {
            alert(woocommerce_photo_reviews_params.i18n_required_comment_text);
            e.preventDefault();
            $content.focus();
            return false;
        }
        if ('on' === woocommerce_photo_reviews_params.enable_photo) {
            if (!$container.attr('enctype') || $container.attr('enctype') !== 'multipart/form-data') {
                $container.attr('enctype', 'multipart/form-data');
            }
            let $fileUpload = $container.find('.wcpr_image_upload');
            if ($fileUpload.length > 0) {
                let file_upload = $fileUpload.get(0).files;
                let imagesCount = parseInt(file_upload.length);
                if ('on' === woocommerce_photo_reviews_params.required_image && imagesCount === 0) {
                    alert(woocommerce_photo_reviews_params.warning_required_image);
                    e.preventDefault();
                    return false;
                }
                if (imagesCount > max_files) {
                    alert(woocommerce_photo_reviews_params.warning_max_files);
                    e.preventDefault();
                    return false;
                }
                let error=[], max_file_size = 1024 * parseFloat(woocommerce_photo_reviews_params.max_file_size);
                jQuery.each(file_upload,function (k,v) {
                    if (woocommerce_photo_reviews_params.upload_allow.indexOf(v.type) === -1){
                        error.push(woocommerce_photo_reviews_params.warning_upload_allow.replace('%file_name%',v.name));
                        return true;
                    }
                    if (v.size > max_file_size){
                        error.push(woocommerce_photo_reviews_params.warning_max_file_size.replace('%file_name%',v.name));
                    }
                });
                if (error.length){
                    alert(error.join('\n'));
                    e.preventDefault();
                    return false;
                }
            } else if ('on' === woocommerce_photo_reviews_params.required_image) {
                alert(woocommerce_photo_reviews_params.warning_required_image);
                e.preventDefault();
                return false;
            }
        }
        if ($name.length > 0 && $name.attr('required') && !$name.val()) {
            alert(woocommerce_photo_reviews_params.i18n_required_name_text);
            e.preventDefault();
            $name.focus();
            return false;
        }
        if ($email.length > 0 && $email.attr('required')&& !$email.val()) {
            alert(woocommerce_photo_reviews_params.i18n_required_email_text);
            e.preventDefault();
            $email.focus();
            return false;
        }

        if ($container.find('input[name="wcpr_gdpr_checkbox"]').prop('checked') === false) {
            alert(woocommerce_photo_reviews_params.warning_gdpr);
            e.preventDefault();
            return false;
        }
    })

});

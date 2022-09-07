jQuery(document).ready(function () {
    let $cur, $n, parent;
    jQuery('body').on('click', '.reviews-images-item', function () {
        let currentRotate, rotateItem;
        parent = jQuery(this).parent().parent();
        currentRotate = parseInt(parent.find('.wcpr-rotate-value').val());
        if (jQuery(this).hasClass('active-image')) {
            parent.find('.big-review-images').hide();
            jQuery(this).removeClass('active-image');
        } else {
            $cur = jQuery(this).attr('data-index');
            $n = jQuery(this).parent().find('.reviews-images-item').length;
            jQuery(this).parent().find('.reviews-images-item').removeClass('active-image');
            jQuery(this).addClass('active-image');
            parent.find('.big-review-images-content').html('');
            parent.find('.big-review-images').hide();
            parent.find('.big-review-images').find('.big-review-images-content').append('<img class="big-review-images-content-img" style="float:left;display: block;border-radius: 3px;" src="' + jQuery(this).attr('data-image_src') + '">')
            parent.find('.big-review-images').css({'display': 'flex'});
        }
        if (currentRotate) {
            rotateItem = parent.find('.big-review-images-content-img');
            rotateItem.css({'transform': 'rotate(' + currentRotate + 'deg)'});
        }
    });

    jQuery('body').on('click', '.wcpr-next', function () {
        let currentRotate, rotateItem;
        parent = jQuery(this).parent().parent();
        currentRotate = parseInt(parent.find('.wcpr-rotate-value').val());
        $cur = parent.find('.active-image').attr('data-index');
        $n = parent.find('.reviews-images-item').length;
        parent.find('.reviews-images-item').removeClass('active-image');
        if ($cur < $n - 1) {

            $cur++;

        } else {
            $cur = 0;
        }
        parent.find('.reviews-images-item').eq($cur).addClass('active-image');
        parent.find('.big-review-images-content').html('');
        parent.find('.big-review-images').hide();
        parent.find('.big-review-images').find('.big-review-images-content').append('<img class="big-review-images-content-img" style="float:left;display: block;border-radius: 3px;" src="' + parent.find('.reviews-images-item').eq($cur).attr('data-image_src') + '">')
        parent.find('.big-review-images').css({'display': 'flex'});
        if (currentRotate) {
            rotateItem = parent.find('.big-review-images-content-img');
            rotateItem.css({'transform': 'rotate(' + currentRotate + 'deg)'});
        }
    });
    jQuery('body').on('click', '.wcpr-prev', function () {
        let currentRotate, rotateItem;
        parent = jQuery(this).parent().parent();
        currentRotate = parseInt(parent.find('.wcpr-rotate-value').val());
        $cur = parent.find('.active-image').attr('data-index');
        $n = parent.find('.reviews-images-item').length;
        parent.find('.reviews-images-item').removeClass('active-image');
        if ($cur > 0) {

            $cur--;

        } else {
            $cur = $n - 1;
        }
        parent.find('.reviews-images-item').eq($cur).addClass('active-image');
        parent.find('.big-review-images-content').html('');
        parent.find('.big-review-images').hide();
        parent.find('.big-review-images').find('.big-review-images-content').append('<img class="big-review-images-content-img" style="float:left;display: block;border-radius: 4px;" src="' + parent.find('.reviews-images-item').eq($cur).attr('data-image_src') + '">')
        parent.find('.big-review-images').css({'display': 'flex'});
        if (currentRotate) {
            rotateItem = parent.find('.big-review-images-content-img');
            rotateItem.css({'transform': 'rotate(' + currentRotate + 'deg)'});
        }
    });

    jQuery('body').on('click', '.wcpr-close', function () {
        parent = jQuery(this).parent().parent();
        jQuery(this).parent().hide();
        parent.find('.kt-wc-reviews-images-wrap-wrap').find('.active-image').removeClass('active-image');
    });
    jQuery('body').on('click', '.wcpr-rotate-left', function () {
        let currentRotate, rotateItem;
        parent = jQuery(this).parent().parent();
        currentRotate = parseInt(parent.find('.wcpr-rotate-value').val());
        rotateItem = parent.find('.big-review-images-content-img');
        currentRotate += -90;
        parent.find('.wcpr-rotate-value').val(currentRotate);
        rotateItem.css({'transform': 'rotate(' + currentRotate + 'deg)'});
    });
    jQuery('body').on('click', '.wcpr-rotate-right', function () {
        let currentRotate, rotateItem;
        parent = jQuery(this).parent().parent();
        currentRotate = parseInt(parent.find('.wcpr-rotate-value').val());
        rotateItem = parent.find('.big-review-images-content-img');
        currentRotate += 90;
        parent.find('.wcpr-rotate-value').val(currentRotate);
        rotateItem.css({'transform': 'rotate(' + currentRotate + 'deg)'});
    });
});
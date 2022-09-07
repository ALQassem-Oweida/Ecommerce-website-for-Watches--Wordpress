jQuery(document).ready(function ($) {
    var current = -1;
    var slides;
    let swipeBoxIndex = 0;
    if ($('.wcpr-grid-item')) {
        slides = $('.wcpr-grid-item');
    }
    $('.wcpr-close').on('click', function () {
        wcpr_enable_scroll();
        $('.wcpr-modal-light-box').fadeOut(200);
        current = -1;

    });
    $('.wcpr-modal-light-box .wcpr-overlay').on('click', function () {
        wcpr_enable_scroll();
        $('.wcpr-modal-light-box').fadeOut(200);
        current = -1;
    });
    $('#reviews-content-left-main').on('click', '.reviews-images', function () {
        let this_image = $(this);
        let data = [];
        $('#reviews-content-left-modal').find('a').map(function () {
            let current_image = $(this).find('.reviews-images');
            let href = $(this).data()['image_src'] ? $(this).data()['image_src'] : current_image.attr('src');
            let title = $(this).data()['image_caption'] ? $(this).data()['image_caption'] : ((parseInt($(this).data()['image_index']) + 1) + '/' + $('#reviews-content-left-modal').find('a').length);
            data.push({href: href, title: title});
        });
        if (data.length == 0) {
            data.push({
                href: this_image.data()['original_src']?this_image.data()['original_src']:this_image.attr('src'),
                title: this_image.parent().find('.wcpr-review-image-caption').html()
            });
        }
        $.swipebox(data, {hideBarsDelay: 100000, initialIndexOnArray: swipeBoxIndex})
    });

    function showReview(n) {
        swipeBoxIndex = 0;
        current = n;
        if (n >= slides.length) {
            current = 0
        }
        if (n < 0) {
            current = slides.length - 1
        }
        $('#reviews-content-left-modal').html('');
        $('#reviews-content-left-main').html('');
        if ($('.wcpr-grid').find('.wcpr-grid-item').eq(current).find('.reviews-images-container').length == 0) {
            $('#reviews-content-left').addClass('wcpr-no-images');
        } else {
            $('#reviews-content-left-modal').html(($('.wcpr-grid').find('.wcpr-grid-item').eq(current).find('.reviews-images-wrap-left').html()));
            let img_data = $('.wcpr-grid').find('.wcpr-grid-item').eq(current).find('.reviews-images-wrap-right').html();
            if (img_data) {
                $('#reviews-content-left').removeClass('wcpr-no-images');
                $('#reviews-content-left-main').html(img_data);
            }
            $('#reviews-content-left-modal').find('.reviews-images').parent().on('click', function () {
                swipeBoxIndex = $(this).data()['image_index'];
                $('#reviews-content-left-main').find('.reviews-images').attr('src', $(this).attr('href'));
                $('#reviews-content-left-main').find('.wcpr-review-image-caption').html($(this).data()['image_caption']);
                return false;
            });
        }
        $('#reviews-content-right .reviews-content-right-meta').html($('.wcpr-grid').find('.wcpr-grid-item').eq(current).find('.review-content-container').html());
        $('.wcpr-modal-light-box').fadeIn(200);
    }

    $(document).keydown(function (e) {
        if ($.swipebox.isOpen) {
            return;
        }
        if($('.wcpr-modal-light-box').css('display')=='none'){
            return;
        }
        if (e.keyCode == 27) {
            wcpr_enable_scroll();
            $('.wcpr-modal-light-box').fadeOut(200);
            current = -1;
        }
        if (current != -1) {
            if (e.keyCode == 37) {
                showReview(current -= 1);
            }
            if (e.keyCode == 39) {
                showReview(current += 1);
            }
        }
    });

    $('body').on('click', '.wcpr-grid-item', function () {
        slides = $('.wcpr-grid-item');
        let i = slides.index($(this));
        if(i>=0){
            showReview(i);
            wcpr_disable_scroll();
        }
    });
    $('body').on('click', '.wcpr-next', function () {
        showReview(current += 1);
    });
    $('body').on('click', '.wcpr-prev', function () {
        showReview(current -= 1);
    });
    function wcpr_enable_scroll() {
        let scrollTop = parseInt($('html').css('top'));
        $('html').removeClass('wcpr-noscroll');
        $('html,body').scrollTop(-scrollTop);
    }

    function wcpr_disable_scroll() {
        if ($(document).height() > $(window).height()) {
            let scrollTop = ($('html').scrollTop()) ? $('html').scrollTop() : $('body').scrollTop(); // Works for Chrome, Firefox, IE...
            $('html').addClass('wcpr-noscroll').css('top', -scrollTop);
        }
    }
});

'use strict';
jQuery(document).ready(function ($) {
    $('.vi-ui.tabular.menu .item').vi_tab({
        history: true,
        historyType: 'hash'
    });
    $('.dropdown').dropdown();
    /*Setup tab*/
    var tabs,
        tabEvent = false,
        initialTab = 'general',
        navSelector = '.vi-ui.menu',
        navFilter = function (el) {
            // return jQuery(el).attr('href').replace(/^#/, '');
        },
        panelSelector = '.vi-ui.tab',
        panelFilter = function () {
            jQuery(panelSelector + ' a').filter(function () {
                return jQuery(navSelector + ' a[title=' + jQuery(this).attr('title') + ']').size() != 0;
            });
        };

    // Initializes plugin features
    jQuery.address.strict(false).wrap(true);

    if (jQuery.address.value() == '') {
        jQuery.address.history(false).value(initialTab).history(true);
    }

    // Address handler
    jQuery.address.init(function (event) {

        // Adds the ID in a lazy manner to prevent scrolling
        jQuery(panelSelector).attr('id', initialTab);

        panelFilter();

        // Tabs setup
        tabs = jQuery('.vi-ui.menu')
            .vi_tab({
                history: true,
                historyType: 'hash'
            })

        // Enables the plugin for all the tabs
        jQuery(navSelector + ' a').click(function (event) {
            tabEvent = true;
            // jQuery.address.value(navFilter(event.target));
            tabEvent = false;
            return true;
        });

    });
    if ($('#kt_coupons_select').prop('disabled') === true) {
        $('.kt-custom-coupon').hide();
        $('.kt-existing-coupons').hide();
    } else {
        if ($('#kt_coupons_select').val() === 'kt_generate_coupon') {
            $('.kt-custom-coupon').show();
            $('.kt-existing-coupons').hide();
        } else {
            $('.kt-custom-coupon').hide();
            $('.kt-existing-coupons').show();
        }
    }

    $('#kt_coupons_select').on('change', function () {
        if ($('#kt_coupons_select').val() === 'kt_generate_coupon') {
            $('.kt-custom-coupon').show();
            $('.kt-existing-coupons').hide();
        } else {
            $('.kt-custom-coupon').hide();
            $('.kt-existing-coupons').show();
        }
    });
    $(".category-search").select2({
        closeOnSelect: false,
        placeholder: "Please enter category title",
        ajax: {
            url: "admin-ajax.php?action=wcpr_search_cate",
            dataType: 'json',
            type: "GET",
            quietMillis: 50,
            delay: 250,
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1
    });
    $(".product-search").select2({
        closeOnSelect: false,
        placeholder: "Please fill in your product title",
        ajax: {
            url: "admin-ajax.php?action=wcpr_search_parent_product",
            dataType: 'json',
            type: "GET",
            quietMillis: 50,
            delay: 250,
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1
    });
    $(".coupon-search").select2({
        placeholder: "Type coupon code here",
        ajax: {
            url: "admin-ajax.php?action=wcpr_search_coupon",
            dataType: 'json',
            type: "GET",
            quietMillis: 50,
            delay: 250,
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1
    });
    /*Color picker*/
    $('.color-picker').not('.verified-color').iris({
        change: function (event, ui) {
            $(this).parent().find('.color-picker').css({backgroundColor: ui.color.toString()});
            let ele = $(this).data('ele');
            if (ele == 'highlight') {
                $('#message-purchased').find('a').css({'color': ui.color.toString()});
            } else if (ele == 'textcolor') {
                $('#message-purchased').css({'color': ui.color.toString()});
            } else {
                $('#message-purchased').css({backgroundColor: ui.color.toString()});
            }
        },
        hide: true,
        border: true
    }).click(function () {
        $('.iris-picker').hide();
        $(this).closest('td').find('.iris-picker').show();
    });

    $('body').click(function () {
        $('.iris-picker').hide();
    });
    $('.color-picker').click(function (event) {
        event.stopPropagation();
    });
    $('#reviews_display1').on('click', function () {
        $('.masonry-options').show();
        $('.default-options').hide();
    });
    $('#reviews_display2').on('click', function () {
        $('.masonry-options').hide();
        $('.default-options').show();
    });

    /*preview email*/
    $('.preview-emails-html-overlay').on('click', function () {
        $('.preview-emails-html-container').addClass('preview-html-hidden');
    });
    $('.coupon-preview-emails-button').on('click', function () {
        let old_preview_text=$(this).html();
        $(this).html(woo_photo_reviews_params_admin.text_please_wait);
        let language=$(this).data()['wcpr_language'];
        $.ajax({
            url: woo_photo_reviews_params_admin.url,
            type: 'GET',
            dataType: 'JSON',
            data: {
                action: 'wcpr_preview_emails',
                email_type: 'coupon',
                heading: $('#heading'+language).val(),
                content: tinyMCE.get('content'+language) ? tinyMCE.get('content'+language).getContent() : $('#content'+language).val(),
            },
            success: function (response) {
                $('.coupon-preview-emails-button[data-wcpr_language="'+language+'"]').html(old_preview_text);
                if (response) {
                    $('.preview-emails-html').html(response.html);
                    $('.preview-emails-html-container').removeClass('preview-html-hidden');
                }
            },
            error: function (err) {
                $('.wcb-preview-emails-button').html(old_preview_text);
            }
        })
    });
    $('.reminder-preview-emails-button').on('click', function () {
        let old_preview_text=$(this).html();
        $(this).html(woo_photo_reviews_params_admin.text_please_wait);
        let language=$(this).data()['wcpr_language'];
        $.ajax({
            url: woo_photo_reviews_params_admin.url,
            type: 'GET',
            dataType: 'JSON',
            data: {
                action: 'wcpr_preview_emails',
                email_type: 'reminder',
                anchor: $('#wcpr-reviews-anchor-link').val(),
                heading: $('#follow_up_email_heading'+language).val(),
                review_button_bg_color: $('#button-review-now-bg-color').val(),
                review_button_color: $('#button-review-now-color').val(),
                content: tinyMCE.get('follow_up_email_content'+language) ? tinyMCE.get('follow_up_email_content'+language).getContent() : $('#follow_up_email_content'+language).val(),
            },
            success: function (response) {
                $('.reminder-preview-emails-button[data-wcpr_language="'+language+'"]').html(old_preview_text);
                if (response) {
                    $('.preview-emails-html').html(response.html);
                    $('.preview-emails-html-container').removeClass('preview-html-hidden');
                }
            },
            error: function (err) {
                $('.wcb-preview-emails-button').html(old_preview_text);
            }
        })
    });
});

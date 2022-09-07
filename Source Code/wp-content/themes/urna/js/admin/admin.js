'use strict';

(function ($) {

  function UrnaAdminModule() {
    var self = this;
    self.init();
  }
  UrnaAdminModule.prototype = {
    init: function () {
      var self = this;
      self.productSizeGuide();
      self.Checkbox();
      self.Datepicker();
    },
    productSizeGuide: function () {
      var product_image_frame;
      var $images_ids = $('#product_size_guide_image');
      var $product_images = $('#product_size_guide_images_container').find('ul.product_size_guide_images');
      $('.add_product_size_guide_images').on('click', 'a', function (event) {
        var $el = $(this);
        event.preventDefault();

        if (product_image_frame) {
          product_image_frame.open();
          return;
        }

        product_image_frame = wp.media.frames.product_gallery = wp.media({
          title: $el.data('choose'),
          button: {
            text: $el.data('update')
          },
          states: [new wp.media.controller.Library({
            title: $el.data('choose'),
            filterable: 'all',
            multiple: false
          })]
        });
        product_image_frame.on('select', function () {
          var selection = product_image_frame.state().get('selection');
          var attachment_ids = $images_ids.val();
          selection.map(function (attachment) {
            attachment = attachment.toJSON();

            if (attachment.id) {
              attachment_ids = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
              var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
              $product_images.find('li.image').remove();
              $product_images.append('<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>');
            }
          });
          $images_ids.val(attachment_ids);
        });
        product_image_frame.open();
      });

      if (typeof $product_images.sortable !== 'undefined') {
        $product_images.sortable({
          items: 'li.image',
          cursor: 'move',
          scrollSensitivity: 40,
          forcePlaceholderSize: true,
          forceHelperSize: false,
          helper: 'clone',
          opacity: 0.65,
          placeholder: 'wc-metabox-sortable-placeholder',
          start: function (event, ui) {
            ui.item.css('background-color', '#f6f6f6');
          },
          stop: function (event, ui) {
            ui.item.removeAttr('style');
          },
          update: function () {
            var attachment_ids = '';
            $('#product_size_guide_images_container').find('ul li.image').css('cursor', 'default').each(function () {
              var attachment_id = $(this).attr('data-attachment_id');
              attachment_ids = attachment_ids + attachment_id + ',';
            });
            $images_ids.val(attachment_ids);
          }
        });
      }

      $('#product_size_guide_images_container').on('click', 'a.delete', function () {
        $(this).closest('li.image').remove();
        var attachment_ids = '';
        $('#product_size_guide_images_container').find('ul li.image').css('cursor', 'default').each(function () {
          var attachment_id = $(this).attr('data-attachment_id');
          attachment_ids = attachment_ids + attachment_id + ',';
        });
        $images_ids.val(attachment_ids);
        $('#tiptip_holder').removeAttr('style');
        $('#tiptip_arrow').removeAttr('style');
        return false;
      });
    },
    Checkbox: function () {
      $("body").on("click", ".tbay-checkbox", function () {
        jQuery('.' + this.id).toggle();
      });
      $('.tbay-wpcolorpicker').each(function () {
        $(this).wpColorPicker();
      });
    },
    Datepicker: function () {
      let $t = $('.tbay-datepicker_field');
      if ($t.length == 0) return;
      $t.datepicker({
        defaultDate: '',
        dateFormat: 'yy-mm-dd',
        numberOfMonths: 1
      });
    }
  };
  $.UrnaAdminModule = UrnaAdminModule.prototype;
  $(document).ready(function () {
    new UrnaAdminModule();
  });
})(jQuery);

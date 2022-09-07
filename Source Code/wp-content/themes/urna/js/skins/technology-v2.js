'use strict';

class General {
  constructor() {
    this._resizeHeaderMenu();

    $(window).on("resize", () => {
      this._resizeHeaderMenu();
    });
  }

  _resizeHeaderMenu() {
    var headermenu = $('.header-mainmenu'),
        header_left = headermenu.find('.header-left'),
        header_main = headermenu.find('.tbay-mainmenu');

    if (typeof urna_settings !== "undefined" && urna_settings.full_width) {
      if ($(window).width() > 1600) {
        if (!header_main.hasClass('col-lg-8')) header_main.addClass('col-lg-8');
        if (!header_left.hasClass('col-lg-2')) header_left.addClass('col-lg-2');
      } else {
        if (header_main.hasClass('col-lg-8')) header_main.removeClass('col-lg-8');
        if (header_left.hasClass('col-lg-2')) header_left.removeClass('col-lg-2');
      }
    }
  }

}

jQuery(document).ready(() => {
  new General();
});

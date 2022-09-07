'use strict';

class General {
  constructor() {
    this._resizeHeaderMain();

    $(window).on("resize", () => {
      this._resizeHeaderMain();
    });
  }

  _resizeHeaderMain() {
    var header = $('.header-main'),
        header_search = header.find('.header-search'),
        header_right = header.find('.header-right');

    if (typeof urna_settings !== "undefined" && urna_settings.full_width) {
      if ($(window).width() > 1600) {
        if (!header_search.hasClass('col-lg-7')) header_search.addClass('col-lg-7');
        if (!header_right.hasClass('col-lg-7')) header_right.addClass('col-lg-2');
      } else {
        if (header_search.hasClass('col-lg-7')) header_search.removeClass('col-lg-7');
        if (header_right.hasClass('col-lg-2')) header_right.removeClass('col-lg-2');
      }
    }
  }

}

jQuery(document).ready(() => {
  new General();
});

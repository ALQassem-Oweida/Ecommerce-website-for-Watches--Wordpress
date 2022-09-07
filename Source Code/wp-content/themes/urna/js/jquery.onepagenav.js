'use strict';

(function ($, window, document, undefined$1) {
  var OnePageNav = function (elem, options) {
    this.elem = elem;
    this.$elem = $(elem);
    this.options = options;
    this.metadata = this.$elem.data('plugin-options');
    this.$win = $(window);
    this.sections = {};
    this.didScroll = false;
    this.$doc = $(document);
    this.docHeight = this.$doc.height();
  };

  OnePageNav.prototype = {
    defaults: {
      navItems: 'a',
      currentClass: 'current',
      changeHash: false,
      easing: 'swing',
      filter: '',
      scrollSpeed: 750,
      scrollThreshold: 0.5,
      begin: false,
      end: false,
      scrollChange: false
    },
    init: function () {
      this.config = $.extend({}, this.defaults, this.options, this.metadata);
      this.$nav = this.$elem.find(this.config.navItems);

      if (this.config.filter !== '') {
        this.$nav = this.$nav.filter(this.config.filter);
      }

      this.$nav.on('click.onePageNav', $.proxy(this.handleClick, this));
      this.getPositions();
      this.bindInterval();
      this.$win.on('resize.onePageNav', $.proxy(this.getPositions, this));
      return this;
    },
    adjustNav: function (self, $parent) {
      self.$elem.find('.' + self.config.currentClass).removeClass(self.config.currentClass);
      $parent.addClass(self.config.currentClass);
    },
    bindInterval: function () {
      var self = this;
      var docHeight;
      self.$win.on('scroll.onePageNav', function () {
        self.didScroll = true;
      });
      self.t = setInterval(function () {
        docHeight = self.$doc.height();

        if (self.didScroll) {
          self.didScroll = false;
          self.scrollChange();
        }

        if (docHeight !== self.docHeight) {
          self.docHeight = docHeight;
          self.getPositions();
        }
      }, 250);
    },
    getHash: function ($link) {
      return $link.attr('href').split('#')[1];
    },
    getPositions: function () {
      var self = this;
      var linkHref;
      var topPos;
      var $target;
      self.$nav.each(function () {
        linkHref = self.getHash($(this));
        $target = $('#' + linkHref);

        if ($target.length) {
          topPos = $target.offset().top;
          self.sections[linkHref] = Math.round(topPos);
        }
      });
    },
    getSection: function (windowPos) {
      var returnValue = null;
      var windowHeight = Math.round(this.$win.height() * this.config.scrollThreshold);

      for (var section in this.sections) {
        if (this.sections[section] - windowHeight < windowPos) {
          returnValue = section;
        }
      }

      return returnValue;
    },
    handleClick: function (e) {
      var self = this;
      var $link = $(e.currentTarget);
      var $parent = $link.parent();
      var newLoc = '#' + self.getHash($link);

      if (!$parent.hasClass(self.config.currentClass)) {
        if (self.config.begin) {
          self.config.begin();
        }

        self.adjustNav(self, $parent);
        self.unbindInterval();
        self.scrollTo(newLoc, function () {
          if (self.config.changeHash) {
            window.location.hash = newLoc;
          }

          self.bindInterval();

          if (self.config.end) {
            self.config.end();
          }
        });
      }

      e.preventDefault();
    },
    scrollChange: function () {
      var windowTop = this.$win.scrollTop();
      var position = this.getSection(windowTop);
      var $parent;

      if (position !== null) {
        $parent = this.$elem.find('a[href$="#' + position + '"]').parent();

        if (!$parent.hasClass(this.config.currentClass)) {
          this.adjustNav(this, $parent);

          if (this.config.scrollChange) {
            this.config.scrollChange($parent);
          }
        }
      }
    },
    scrollTo: function (target, callback) {
      var offset = $(target).offset().top;
      $('html, body').animate({
        scrollTop: offset - this.config.scrollOffset
      }, this.config.scrollSpeed, this.config.easing, callback);
    },
    unbindInterval: function () {
      clearInterval(this.t);
      this.$win.unbind('scroll.onePageNav');
    }
  };
  OnePageNav.defaults = OnePageNav.prototype.defaults;

  $.fn.onePageNav = function (options) {
    return this.each(function () {
      new OnePageNav(this, options).init();
    });
  };
})(jQuery, window, document);

class OnePageNav {
  constructor() {
    this._productSingleOnepagenav();
  }

  _productSingleOnepagenav() {
    if ($('#sticky-menu-bar').length > 0) {
      let offset_adminbar = 0;

      if ($('#wpadminbar').length > 0) {
        offset_adminbar = $('#wpadminbar').outerHeight();
      }

      let offset = $('#sticky-menu-bar').outerHeight() + offset_adminbar;
      $('#sticky-menu-bar').onePageNav({
        currentClass: 'current',
        changeHash: false,
        scrollSpeed: 750,
        scrollThreshold: 0.5,
        scrollOffset: offset,
        filter: '',
        easing: 'swing',
        begin: function () {},
        end: function () {},
        scrollChange: function () {}
      });
    }

    var onepage = $('#sticky-menu-bar');

    if (onepage.length > 0) {
      if ($('#tbay-header').length === 0 && $('#tbay-customize-header').length === 0) return;
      var tbay_width = $(window).width();

      if ($('#tbay-header').length > 0) {
        $('#tbay-header').removeClass('main-sticky-header');
      }

      if ($('#tbay-customize-header').length > 0) {
        $('#tbay-customize-header').removeClass('main-sticky-header');
      }

      var btn_cart_offset = $('.single_add_to_cart_button').length > 0 ? $('.single_add_to_cart_button').offset().top : 0;
      var out_of_stock_offset = $('div.product .out-of-stock').length > 0 ? $('div.product .out-of-stock').offset().top : 0;

      if ($('.by-vendor-name-link').length > 0) {
        out_of_stock_offset = $('.by-vendor-name-link').offset().top;
      }

      var sum_height = $('.single_add_to_cart_button').length > 0 ? btn_cart_offset : out_of_stock_offset;

      this._checkScroll(tbay_width, sum_height, onepage);

      $(window).scroll(() => {
        this._checkScroll(tbay_width, sum_height, onepage);
      });
    }

    if (onepage.hasClass('active') && jQuery('#wpadminbar').length > 0) {
      onepage.css('top', $('#wpadminbar').height());
    }
  }

  _checkScroll(tbay_width, sum_height, onepage) {
    if (tbay_width >= 768) {
      var NextScroll = $(window).scrollTop();

      if (NextScroll > sum_height) {
        onepage.addClass('active');

        if (jQuery('#wpadminbar').length > 0) {
          onepage.css('top', $('#wpadminbar').height());
        }
      } else {
        onepage.removeClass('active');
      }
    } else {
      onepage.removeClass('active');
    }
  }

}

$(document).ready(function ($) {
  new OnePageNav();
});

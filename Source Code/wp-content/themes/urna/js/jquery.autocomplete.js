'use strict';

(function (factory) {

  if (typeof define === 'function' && define.amd) {
    define(['jquery'], factory);
  } else if (typeof exports === 'object' && typeof require === 'function') {
    factory(require('jquery'));
  } else {
    factory(jQuery);
  }
})(function ($) {

  var utils = function () {
    return {
      escapeRegExChars: function (value) {
        return value.replace(/[|\\{}()[\]^$+*?.]/g, "\\$&");
      },
      createNode: function (containerClass) {
        var div = document.createElement('div');
        div.className = containerClass;
        div.style.position = 'absolute';
        div.style.display = 'none';
        return div;
      }
    };
  }(),
      keys = {
    ESC: 27,
    TAB: 9,
    RETURN: 13,
    LEFT: 37,
    UP: 38,
    RIGHT: 39,
    DOWN: 40
  },
      noop = $.noop;

  function Autocomplete(el, options) {
    var that = this;
    that.element = el;
    that.el = $(el);
    that.suggestions = [];
    that.badQueries = [];
    that.selectedIndex = -1;
    that.currentValue = that.element.value;
    that.timeoutId = null;
    that.cachedResponse = {};
    that.onChangeTimeout = null;
    that.onChange = null;
    that.isLocal = false;
    that.suggestionsContainer = null;
    that.noSuggestionsContainer = null;
    that.options = $.extend(true, {}, Autocomplete.defaults, options);
    that.classes = {
      selected: 'autocomplete-selected',
      suggestion: 'autocomplete-suggestion'
    };
    that.hint = null;
    that.hintValue = '';
    that.selection = null;
    that.initialize();
    that.setOptions(options);
  }

  Autocomplete.utils = utils;
  $.Autocomplete = Autocomplete;
  Autocomplete.defaults = {
    ajaxSettings: {},
    autoSelectFirst: false,
    appendTo: 'body',
    serviceUrl: null,
    lookup: null,
    onSelect: null,
    width: 'auto',
    minChars: 1,
    maxHeight: 300,
    deferRequestBy: 0,
    params: {},
    formatResult: _formatResult,
    formatGroup: _formatGroup,
    delimiter: null,
    zIndex: 9999,
    type: 'GET',
    noCache: false,
    onSearchStart: noop,
    onSearchComplete: noop,
    onSearchError: noop,
    preserveInput: false,
    containerClass: 'autocomplete-suggestions',
    tabDisabled: false,
    dataType: 'text',
    currentRequest: null,
    triggerSelectOnValidInput: true,
    preventBadQueries: true,
    lookupFilter: _lookupFilter,
    paramName: 'query',
    transformResult: _transformResult,
    showNoSuggestionNotice: false,
    noSuggestionNotice: 'No results',
    orientation: 'bottom',
    forceFixPosition: false
  };

  function _lookupFilter(suggestion, originalQuery, queryLowerCase) {
    return suggestion.value.toLowerCase().indexOf(queryLowerCase) !== -1;
  }

  function _transformResult(response) {
    return typeof response === 'string' ? $.parseJSON(response) : response;
  }

  function _formatResult(suggestion, currentValue) {
    if (!currentValue) {
      return suggestion.value;
    }

    var pattern = '(' + utils.escapeRegExChars(currentValue) + ')';
    return suggestion.value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/&lt;(\/?strong)&gt;/g, '<$1>');
  }

  function _formatGroup(suggestion, category) {
    return '<div class="autocomplete-group">' + category + '</div>';
  }
  Autocomplete.prototype = {
    initialize: function () {
      var that = this,
          suggestionSelector = '.' + that.classes.suggestion,
          selected = that.classes.selected,
          options = that.options,
          container;
      that.element.setAttribute('autocomplete', 'off');
      that.noSuggestionsContainer = $('<div class="autocomplete-no-suggestion"></div>').html(this.options.noSuggestionNotice).get(0);
      that.suggestionsContainer = Autocomplete.utils.createNode(options.containerClass);
      container = $(that.suggestionsContainer);
      container.appendTo(options.appendTo || 'body');

      if (options.width !== 'auto') {
        container.css('width', options.width);
      }

      container.on('mouseover.autocomplete', suggestionSelector, function () {
        that.activate($(this).data('index'));
      });
      container.on('mouseout.autocomplete', function () {
        that.selectedIndex = -1;
        container.children('.' + selected).removeClass(selected);
      });
      container.on('click.autocomplete', suggestionSelector, function () {
        that.select($(this).data('index'));
      });
      container.on('click.autocomplete', function () {
        clearTimeout(that.blurTimeoutId);
      });

      that.fixPositionCapture = function () {
        if (that.visible) {
          that.fixPosition();
        }
      };

      $(window).on('resize.autocomplete', that.fixPositionCapture);
      that.el.on('keydown.autocomplete', function (e) {
        that.onKeyPress(e);
      });
      that.el.on('keyup.autocomplete', function (e) {
        that.onKeyUp(e);
      });
      that.el.on('blur.autocomplete', function () {
        that.onBlur();
      });
      that.el.on('focus.autocomplete', function () {
        that.onFocus();
      });
      that.el.on('change.autocomplete', function (e) {
        that.onKeyUp(e);
      });
    },
    onFocus: function () {
      var that = this;
      that.fixPosition();

      if (that.el.val().length >= that.options.minChars) {
        that.onValueChange();
      }
    },
    onBlur: function () {
      var that = this;
      that.blurTimeoutId = setTimeout(function () {
        that.hide();
      }, 200);
    },
    abortAjax: function () {
      var that = this;

      if (that.currentRequest) {
        that.currentRequest.abort();
        that.currentRequest = null;
      }
    },
    setOptions: function (suppliedOptions) {
      var that = this,
          options = $.extend({}, that.options, suppliedOptions);
      that.isLocal = Array.isArray(options.lookup);

      if (that.isLocal) {
        options.lookup = that.verifySuggestionsFormat(options.lookup);
      }

      options.orientation = that.validateOrientation(options.orientation, 'bottom');
      $(that.suggestionsContainer).css({
        'max-height': options.maxHeight + 'px',
        'width': options.width + 'px',
        'z-index': options.zIndex
      });
      this.options = options;
    },
    clearCache: function () {
      this.cachedResponse = {};
      this.badQueries = [];
    },
    clear: function () {
      this.clearCache();
      this.currentValue = '';
      this.suggestions = [];
    },
    disable: function () {
      var that = this;
      that.disabled = true;
      clearTimeout(that.onChangeTimeout);
      that.abortAjax();
    },
    enable: function () {
      this.disabled = false;
    },
    fixPosition: function () {
      var that = this,
          $container = $(that.suggestionsContainer),
          containerParent = $container.parent().get(0);

      if (containerParent !== document.body && !that.options.forceFixPosition) {
        return;
      }

      var orientation = that.options.orientation,
          containerHeight = $container.outerHeight(),
          height = that.el.outerHeight(),
          offset = that.el.offset(),
          styles = {
        'top': offset.top,
        'left': offset.left
      };

      if (orientation === 'auto') {
        var viewPortHeight = $(window).height(),
            scrollTop = $(window).scrollTop(),
            topOverflow = -scrollTop + offset.top - containerHeight,
            bottomOverflow = scrollTop + viewPortHeight - (offset.top + height + containerHeight);
        orientation = Math.max(topOverflow, bottomOverflow) === topOverflow ? 'top' : 'bottom';
      }

      if (orientation === 'top') {
        styles.top += -containerHeight;
      } else {
        styles.top += height;
      }

      if (containerParent !== document.body) {
        var opacity = $container.css('opacity'),
            parentOffsetDiff;

        if (!that.visible) {
          $container.css('opacity', 0).show();
        }

        parentOffsetDiff = $container.offsetParent().offset();
        styles.top -= parentOffsetDiff.top;
        styles.top += containerParent.scrollTop;
        styles.left -= parentOffsetDiff.left;

        if (!that.visible) {
          $container.css('opacity', opacity).hide();
        }
      }

      if (that.options.width === 'auto') {
        styles.width = that.el.outerWidth() + 'px';
      }

      $container.css(styles);
    },
    isCursorAtEnd: function () {
      var that = this,
          valLength = that.el.val().length,
          selectionStart = that.element.selectionStart,
          range;

      if (typeof selectionStart === 'number') {
        return selectionStart === valLength;
      }

      if (document.selection) {
        range = document.selection.createRange();
        range.moveStart('character', -valLength);
        return valLength === range.text.length;
      }

      return true;
    },
    onKeyPress: function (e) {
      var that = this;

      if (!that.disabled && !that.visible && e.which === keys.DOWN && that.currentValue) {
        that.suggest();
        return;
      }

      if (that.disabled || !that.visible) {
        return;
      }

      switch (e.which) {
        case keys.ESC:
          that.el.val(that.currentValue);
          that.hide();
          break;

        case keys.RIGHT:
          if (that.hint && that.options.onHint && that.isCursorAtEnd()) {
            that.selectHint();
            break;
          }

          return;

        case keys.TAB:
          if (that.hint && that.options.onHint) {
            that.selectHint();
            return;
          }

          if (that.selectedIndex === -1) {
            that.hide();
            return;
          }

          that.select(that.selectedIndex);

          if (that.options.tabDisabled === false) {
            return;
          }

          break;

        case keys.RETURN:
          if (that.selectedIndex === -1) {
            that.hide();
            return;
          }

          that.select(that.selectedIndex);
          break;

        case keys.UP:
          that.moveUp();
          break;

        case keys.DOWN:
          that.moveDown();
          break;

        default:
          return;
      }

      e.stopImmediatePropagation();
      e.preventDefault();
    },
    onKeyUp: function (e) {
      var that = this;

      if (that.disabled) {
        return;
      }

      switch (e.which) {
        case keys.UP:
        case keys.DOWN:
          return;
      }

      clearTimeout(that.onChangeTimeout);

      if (that.currentValue !== that.el.val()) {
        that.findBestHint();

        if (that.options.deferRequestBy > 0) {
          that.onChangeTimeout = setTimeout(function () {
            that.onValueChange();
          }, that.options.deferRequestBy);
        } else {
          that.onValueChange();
        }
      }
    },
    onValueChange: function () {
      if (this.ignoreValueChange) {
        this.ignoreValueChange = false;
        return;
      }

      var that = this,
          options = that.options,
          value = that.el.val(),
          query = that.getQuery(value);

      if (that.selection && that.currentValue !== query) {
        that.selection = null;
        (options.onInvalidateSelection || $.noop).call(that.element);
      }

      clearTimeout(that.onChangeTimeout);
      that.currentValue = value;
      that.selectedIndex = -1;

      if (options.triggerSelectOnValidInput && that.isExactMatch(query)) {
        that.select(0);
        return;
      }

      if (query.length < options.minChars) {
        that.hide();
      } else {
        that.getSuggestions(query);
      }
    },
    isExactMatch: function (query) {
      var suggestions = this.suggestions;
      return suggestions.length === 1 && suggestions[0].value.toLowerCase() === query.toLowerCase();
    },
    getQuery: function (value) {
      var delimiter = this.options.delimiter,
          parts;

      if (!delimiter) {
        return value;
      }

      parts = value.split(delimiter);
      return $.trim(parts[parts.length - 1]);
    },
    getSuggestionsLocal: function (query) {
      var that = this,
          options = that.options,
          queryLowerCase = query.toLowerCase(),
          filter = options.lookupFilter,
          limit = parseInt(options.lookupLimit, 10),
          data;
      data = {
        suggestions: $.grep(options.lookup, function (suggestion) {
          return filter(suggestion, query, queryLowerCase);
        })
      };

      if (limit && data.suggestions.length > limit) {
        data.suggestions = data.suggestions.slice(0, limit);
      }

      return data;
    },
    getSuggestions: function (q) {
      var response,
          that = this,
          options = that.options,
          serviceUrl = options.serviceUrl,
          params,
          cacheKey,
          ajaxSettings;
      options.params[options.paramName] = q;

      if (options.onSearchStart.call(that.element, options.params) === false) {
        return;
      }

      params = options.ignoreParams ? null : options.params;

      if ($.isFunction(options.lookup)) {
        options.lookup(q, function (data) {
          that.suggestions = data.suggestions;
          that.suggest();
          options.onSearchComplete.call(that.element, q, data.suggestions);
        });
        return;
      }

      if (that.isLocal) {
        response = that.getSuggestionsLocal(q);
      } else {
        if ($.isFunction(serviceUrl)) {
          serviceUrl = serviceUrl.call(that.element, q);
        }

        cacheKey = serviceUrl + '?' + $.param(params || {});
        response = that.cachedResponse[cacheKey];
      }

      if (response && Array.isArray(response.suggestions)) {
        that.suggestions = response.suggestions;
        that.suggest();
        options.onSearchComplete.call(that.element, q, response.suggestions);
      } else if (!that.isBadQuery(q)) {
        that.abortAjax();
        ajaxSettings = {
          url: serviceUrl,
          data: params,
          type: options.type,
          dataType: options.dataType
        };
        $.extend(ajaxSettings, options.ajaxSettings);
        that.currentRequest = $.ajax(ajaxSettings).done(function (data) {
          var result;
          that.currentRequest = null;
          result = options.transformResult(data, q);
          that.processResponse(result, q, cacheKey);
          options.onSearchComplete.call(that.element, q, result.suggestions);
        }).fail(function (jqXHR, textStatus, errorThrown) {
          options.onSearchError.call(that.element, q, jqXHR, textStatus, errorThrown);
        });
      } else {
        options.onSearchComplete.call(that.element, q, []);
      }
    },
    isBadQuery: function (q) {
      if (!this.options.preventBadQueries) {
        return false;
      }

      var badQueries = this.badQueries,
          i = badQueries.length;

      while (i--) {
        if (q.indexOf(badQueries[i]) === 0) {
          return true;
        }
      }

      return false;
    },
    hide: function () {
      var that = this,
          container = $(that.suggestionsContainer);

      if ($.isFunction(that.options.onHide) && that.visible) {
        that.options.onHide.call(that.element, container);
      }

      that.visible = false;
      that.selectedIndex = -1;
      clearTimeout(that.onChangeTimeout);
      $(that.suggestionsContainer).hide();
      that.signalHint(null);
    },
    suggest: function () {
      if (!this.suggestions.length) {
        if (this.options.showNoSuggestionNotice) {
          this.noSuggestions();
        } else {
          this.hide();
        }

        return;
      }

      var that = this,
          options = that.options,
          groupBy = options.groupBy,
          formatResult = options.formatResult,
          value = that.getQuery(that.currentValue),
          className = that.classes.suggestion,
          classSelected = that.classes.selected,
          container = $(that.suggestionsContainer),
          noSuggestionsContainer = $(that.noSuggestionsContainer),
          beforeRender = options.beforeRender,
          html = '',
          category,
          formatGroup = function (suggestion, index) {
        var currentCategory = suggestion.data[groupBy];

        if (category === currentCategory) {
          return '';
        }

        category = currentCategory;
        return options.formatGroup(suggestion, category);
      };

      if (options.triggerSelectOnValidInput && that.isExactMatch(value)) {
        that.select(0);
        return;
      }

      $.each(that.suggestions, function (i, suggestion) {
        if (groupBy) {
          html += formatGroup(suggestion, value, i);
        }

        html += '<div class="' + className + '" data-index="' + i + '">' + formatResult(suggestion, value, i) + '</div>';
      });
      this.adjustContainerWidth();
      noSuggestionsContainer.detach();
      container.html(html);

      if ($.isFunction(beforeRender)) {
        beforeRender.call(that.element, container, that.suggestions);
      }

      that.fixPosition();
      container.show();

      if (options.autoSelectFirst) {
        that.selectedIndex = 0;
        container.scrollTop(0);
        container.children('.' + className).first().addClass(classSelected);
      }

      that.visible = true;
      that.findBestHint();
    },
    noSuggestions: function () {
      var that = this,
          beforeRender = that.options.beforeRender,
          container = $(that.suggestionsContainer),
          noSuggestionsContainer = $(that.noSuggestionsContainer);
      this.adjustContainerWidth();
      noSuggestionsContainer.detach();
      container.empty();
      container.append(noSuggestionsContainer);

      if ($.isFunction(beforeRender)) {
        beforeRender.call(that.element, container, that.suggestions);
      }

      that.fixPosition();
      container.show();
      that.visible = true;
    },
    adjustContainerWidth: function () {
      var that = this,
          options = that.options,
          width,
          container = $(that.suggestionsContainer);

      if (options.width === 'auto') {
        width = that.el.outerWidth();
        container.css('width', width > 0 ? width : 300);
      } else if (options.width === 'flex') {
        container.css('width', '');
      }
    },
    findBestHint: function () {
      var that = this,
          value = that.el.val().toLowerCase(),
          bestMatch = null;

      if (!value) {
        return;
      }

      $.each(that.suggestions, function (i, suggestion) {
        var foundMatch = suggestion.value.toLowerCase().indexOf(value) === 0;

        if (foundMatch) {
          bestMatch = suggestion;
        }

        return !foundMatch;
      });
      that.signalHint(bestMatch);
    },
    signalHint: function (suggestion) {
      var hintValue = '',
          that = this;

      if (suggestion) {
        hintValue = that.currentValue + suggestion.value.substr(that.currentValue.length);
      }

      if (that.hintValue !== hintValue) {
        that.hintValue = hintValue;
        that.hint = suggestion;
        (this.options.onHint || $.noop)(hintValue);
      }
    },
    verifySuggestionsFormat: function (suggestions) {
      if (suggestions.length && typeof suggestions[0] === 'string') {
        return $.map(suggestions, function (value) {
          return {
            value: value,
            data: null
          };
        });
      }

      return suggestions;
    },
    validateOrientation: function (orientation, fallback) {
      orientation = $.trim(orientation || '').toLowerCase();

      if ($.inArray(orientation, ['auto', 'bottom', 'top']) === -1) {
        orientation = fallback;
      }

      return orientation;
    },
    processResponse: function (result, originalQuery, cacheKey) {
      var that = this,
          options = that.options;
      result.suggestions = that.verifySuggestionsFormat(result.suggestions);

      if (!options.noCache) {
        that.cachedResponse[cacheKey] = result;

        if (options.preventBadQueries && !result.suggestions.length) {
          that.badQueries.push(originalQuery);
        }
      }

      if (originalQuery !== that.getQuery(that.currentValue)) {
        return;
      }

      that.suggestions = result.suggestions;
      that.suggest();
    },
    activate: function (index) {
      var that = this,
          activeItem,
          selected = that.classes.selected,
          container = $(that.suggestionsContainer),
          children = container.find('.' + that.classes.suggestion);
      container.find('.' + selected).removeClass(selected);
      that.selectedIndex = index;

      if (that.selectedIndex !== -1 && children.length > that.selectedIndex) {
        activeItem = children.get(that.selectedIndex);
        $(activeItem).addClass(selected);
        return activeItem;
      }

      return null;
    },
    selectHint: function () {
      var that = this,
          i = $.inArray(that.hint, that.suggestions);
      that.select(i);
    },
    select: function (i) {
      var that = this;
      that.hide();
      that.onSelect(i);
    },
    moveUp: function () {
      var that = this;

      if (that.selectedIndex === -1) {
        return;
      }

      if (that.selectedIndex === 0) {
        $(that.suggestionsContainer).children('.' + that.classes.suggestion).first().removeClass(that.classes.selected);
        that.selectedIndex = -1;
        that.ignoreValueChange = false;
        that.el.val(that.currentValue);
        that.findBestHint();
        return;
      }

      that.adjustScroll(that.selectedIndex - 1);
    },
    moveDown: function () {
      var that = this;

      if (that.selectedIndex === that.suggestions.length - 1) {
        return;
      }

      that.adjustScroll(that.selectedIndex + 1);
    },
    adjustScroll: function (index) {
      var that = this,
          activeItem = that.activate(index);

      if (!activeItem) {
        return;
      }

      var offsetTop,
          upperBound,
          lowerBound,
          heightDelta = $(activeItem).outerHeight();
      offsetTop = activeItem.offsetTop;
      upperBound = $(that.suggestionsContainer).scrollTop();
      lowerBound = upperBound + that.options.maxHeight - heightDelta;

      if (offsetTop < upperBound) {
        $(that.suggestionsContainer).scrollTop(offsetTop);
      } else if (offsetTop > lowerBound) {
        $(that.suggestionsContainer).scrollTop(offsetTop - that.options.maxHeight + heightDelta);
      }

      if (!that.options.preserveInput) {
        that.ignoreValueChange = true;
        that.el.val(that.getValue(that.suggestions[index].value));
      }

      that.signalHint(null);
    },
    onSelect: function (index) {
      var that = this,
          onSelectCallback = that.options.onSelect,
          suggestion = that.suggestions[index];
      that.currentValue = that.getValue(suggestion.value);

      if (that.currentValue !== that.el.val() && !that.options.preserveInput) {
        that.el.val(that.currentValue);
      }

      that.signalHint(null);
      that.suggestions = [];
      that.selection = suggestion;

      if ($.isFunction(onSelectCallback)) {
        onSelectCallback.call(that.element, suggestion);
      }
    },
    getValue: function (value) {
      var that = this,
          delimiter = that.options.delimiter,
          currentValue,
          parts;

      if (!delimiter) {
        return value;
      }

      currentValue = that.currentValue;
      parts = currentValue.split(delimiter);

      if (parts.length === 1) {
        return value;
      }

      return currentValue.substr(0, currentValue.length - parts[parts.length - 1].length) + value;
    },
    dispose: function () {
      var that = this;
      that.el.off('.autocomplete').removeData('autocomplete');
      $(window).off('resize.autocomplete', that.fixPositionCapture);
      $(that.suggestionsContainer).remove();
    }
  };

  $.fn.devbridgeAutocomplete = function (options, args) {
    var dataKey = 'autocomplete';

    if (!arguments.length) {
      return this.first().data(dataKey);
    }

    return this.each(function () {
      var inputElement = $(this),
          instance = inputElement.data(dataKey);

      if (typeof options === 'string') {
        if (instance && typeof instance[options] === 'function') {
          instance[options](args);
        }
      } else {
        if (instance && instance.dispose) {
          instance.dispose();
        }

        instance = new Autocomplete(this, options);
        inputElement.data(dataKey, instance);
      }
    });
  };

  if (!$.fn.autocomplete) {
    $.fn.autocomplete = $.fn.devbridgeAutocomplete;
  }
});

class AutoComplete {
  constructor() {
    if (typeof urna_settings === "undefined") return;

    this._callAjaxSearch();
  }

  _callAjaxSearch() {
    var _this = this,
        url = urna_settings.ajaxurl + '?action=urna_autocomplete_search&security=' + urna_settings.search_nonce,
        form = $('form.searchform.urna-ajax-search'),
        RegEx = function (value) {
      return value.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
    };

    form.each(function () {
      var _this2 = $(this),
          autosearch = _this2.find('input[name=s]'),
          image = parseInt(_this2.data('thumbnail')),
          price = parseInt(_this2.data('price'));

      autosearch.devbridgeAutocomplete({
        serviceUrl: _this._AutoServiceUrl(autosearch, url),
        minChars: _this._AutoMinChars(autosearch),
        appendTo: _this._AutoAppendTo(autosearch),
        width: '100%',
        maxHeight: 'initial',
        onSelect: function (suggestion) {
          if (suggestion.link.length > 0) window.location.href = suggestion.link;
        },
        onSearchStart: function (query) {
          let form = autosearch.parents('form');
          form.addClass('tbay-loading');
        },
        beforeRender: function (container, suggestion) {
          if (typeof suggestion[0].result != 'undefined') {
            $(container).prepend('<div class="list-header"><span>' + suggestion[0].result + '</span></div>');
          }

          if (suggestion[0].view_all) {
            $(container).append('<div class="view-all-products"><span>' + urna_settings.show_all_text + '</span><i class="linear-icon-chevron-right"></i></div>');
          }
        },
        onSearchComplete: function (query, suggestions) {
          form.removeClass('tbay-loading');
          $(this).parents('form').addClass('open');
          $(document.body).trigger('urna_searchcomplete');
        },
        formatResult: (suggestion, currentValue) => {
          let returnValue = _this._initformatResult(suggestion, currentValue, RegEx, image, price);

          return returnValue;
        },
        onHide: function (container) {
          if ($(this).parents('form').hasClass('open')) $(this).parents('form').removeClass('open');
        }
      });
      $('body').click(function () {
        if (autosearch.is(":focus")) {
          return;
        }

        autosearch.each(function () {
          let ac = $(this).devbridgeAutocomplete();
          ac.hide();
        });
      });
    });
    var cat_change = form.find('[name="product_cat"], [name="category"]');

    if (cat_change.length) {
      cat_change.change(function (e) {
        let se_input = $(e.target).parents('form').find('input[name=s]'),
            ac = se_input.devbridgeAutocomplete();
        ac.hide();
        ac.setOptions({
          serviceUrl: _this._AutoServiceUrl(se_input, url)
        });
        ac.onValueChange();
      });
    }

    $(document.body).on('urna_searchcomplete', function () {
      $(".view-all-products").on("click", function () {
        $(this).parents('form').submit();
      });
    });
  }

  _AutoServiceUrl(autosearch, url) {
    let form = autosearch.parents('form'),
        number = parseInt(form.data('count')),
        postType = form.data('post-type'),
        search_in = form.data('search-in'),
        product_cat = form.find('[name="product_cat"], [name="category"]').val();

    if (number > 0) {
      url += '&number=' + number;
    }

    url += '&search_in=' + search_in;
    url += '&post_type=' + postType;

    if (product_cat) {
      url += '&product_cat=' + product_cat;
    }

    return url;
  }

  _AutoAppendTo(autosearch) {
    let form = autosearch.parents('form'),
        appendTo = typeof form.data('appendto') !== 'undefined' ? form.data('appendto') : form.find('.urna-search-results');
    return appendTo;
  }

  _AutoMinChars(autosearch) {
    let form = autosearch.parents('form'),
        minChars = parseInt(form.data('minchars'));
    return minChars;
  }

  _initformatResult(suggestion, currentValue, RegEx, image, price) {
    if (currentValue == '&') currentValue = "&#038;";
    var pattern = '(' + RegEx(currentValue) + ')',
        returnValue = '';

    if (image && suggestion.image) {
      returnValue += ' <div class="suggestion-thumb">' + suggestion.image + '</div>';
    }

    returnValue += '<div class="suggestion-group">';
    returnValue += '<div class="suggestion-title product-title">' + suggestion.value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/&lt;(\/?strong)&gt;/g, '<$1>') + '</div>';
    if (suggestion.no_found) returnValue = '<div class="suggestion-title no-found-msg">' + suggestion.value + '</div>';

    if (price && suggestion.price) {
      returnValue += ' <div class="suggestion-price price">' + suggestion.price + '</div>';
    }

    returnValue += '</div>';
    return returnValue;
  }

}

$(document).ready(() => {
  new AutoComplete();
});

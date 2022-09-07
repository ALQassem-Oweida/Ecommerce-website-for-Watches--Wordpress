'use strict';

class customLogin {
  constructor() {
    this._changeDefaultErrorMessage();

    this._initLogin();
  }

  _initLogin() {
    jQuery('form#custom-login, form#custom-register').on('submit', function (e) {
      if (!$(this).valid()) return false;
      $('p.status', this).show().text(urna_ajax_auth_object.loadingmessage);
      var action = 'ajaxlogin';
      var username = $('form#custom-login #cus-username').val();
      var password = $('form#custom-login #cus-password').val();
      var rememberme = $('#cus-rememberme').is(':checked') ? true : false;
      var email = '';
      security = $('form#custom-login #security').val();

      if ($(this).attr('id') == 'custom-register') {
        action = 'ajaxregister';
        username = $('#signonname').val();
        password = $('#signonpassword').val();
        email = $('#signonemail').val();
        var security = $('#signonsecurity').val();
      }

      var self = $(this);
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: urna_ajax_auth_object.ajaxurl,
        data: {
          'action': action,
          'username': username,
          'password': password,
          'email': email,
          'rememberme': rememberme,
          'security': security
        },
        success: function (data) {
          $('p.status', self).text(data.message);

          if (data.loggedin == true) {
            $('p.status', self).addClass('successful');
            document.location.reload();
          } else {
            $('p.status', self).addClass('wrong');
          }
        }
      });
      e.preventDefault();
    });
    if (jQuery("#custom-register").length) jQuery("#custom-register").validate({
      rules: {
        password2: {
          equalTo: '#signonpassword'
        }
      }
    });else if (jQuery("#custom-login").length) jQuery("#custom-login").validate();
  }

  _changeDefaultErrorMessage() {
    jQuery.extend(jQuery.validator.messages, {
      required: urna_ajax_auth_object.validate.required,
      remote: urna_ajax_auth_object.validate.remote,
      email: urna_ajax_auth_object.validate.email,
      url: urna_ajax_auth_object.validate.url,
      date: urna_ajax_auth_object.validate.date,
      dateISO: urna_ajax_auth_object.validate.dateISO,
      number: urna_ajax_auth_object.validate.number,
      digits: urna_ajax_auth_object.validate.digits,
      creditcard: urna_ajax_auth_object.validate.creditcard,
      equalTo: urna_ajax_auth_object.validate.equalTo,
      accept: urna_ajax_auth_object.validate.accept,
      maxlength: jQuery.validator.format(urna_ajax_auth_object.validate.maxlength),
      minlength: jQuery.validator.format(urna_ajax_auth_object.validate.minlength),
      rangelength: jQuery.validator.format(urna_ajax_auth_object.validate.rangelength),
      range: jQuery.validator.format(urna_ajax_auth_object.validate.range),
      max: jQuery.validator.format(urna_ajax_auth_object.validate.max),
      min: jQuery.validator.format(urna_ajax_auth_object.validate.min)
    });
  }

}

jQuery(document).ready(function ($) {
  new customLogin();
});

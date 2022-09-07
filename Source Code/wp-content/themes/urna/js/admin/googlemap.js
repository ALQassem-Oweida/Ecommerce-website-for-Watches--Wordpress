'use strict';

!function ($) {
  if ($('#geocomplete').length > 0) {
    var _lat_lng = $('input[name=lat_lng]').val();

    var loca = _lat_lng;
    _lat_lng = _lat_lng.split(',');
    var center = new google.maps.LatLng(_lat_lng[0], _lat_lng[1]);
    $("#geocomplete").geocomplete({
      map: ".map_canvas",
      types: ["establishment"],
      country: "de",
      details: ".mapdetail",
      markerOptions: {
        draggable: true
      },
      location: loca,
      mapOptions: {
        scrollwheel: true,
        zoom: 15,
        center: center
      }
    });
    $(".googlefind button.find").on("click", function () {
      $("#geocomplete").trigger("geocode");
    });
    $("#geocomplete").on("geocode:dragged", function (event, latLng) {
      $("input[name=lat]").val(latLng.lat());
      $("input[name=lng]").val(latLng.lng());
      $("input[name=lat_lng]").val(latLng.lat() + ',' + latLng.lng());
    }).on("geocode:result", function (event, latLng) {
      $('.tbay-latgmap,.tbay-lnggmap').trigger('change');
    });
    $('.tbay-latgmap,.tbay-lnggmap').keyup(function (event) {
      var value = $('.tbay-latgmap').val() + ',' + $('.tbay-lnggmap').val();
      $("input[name=lat_lng]").val(value);
    }).change(function () {
      var value = $('.tbay-latgmap').val() + ',' + $('.tbay-lnggmap').val();
      $("input[name=lat_lng]").val(value);
    });
  }
}(window.jQuery);

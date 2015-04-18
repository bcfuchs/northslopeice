<?php
/**
Template Name: Map
*/
?>
<style>
.sidebar-wrap {
display:none;

}
#comments {
display: none;

}

  html { height: 100% }
  body { height: 100%; margin: 0; padding: 0 }
  #map-canvas { height: 500px ; width: 100%;}
  #map-header {
  margin-bottom: 10px;
  width: 500px;
  
  }
  
  #adddata {
  margin-left: 40px;
  margin-bottom: 10px;
  
  }

@media (min-width: 1200px)
.container {
 // width: 100%;
}
</style>
<div id="map-header" style="display:inline">
<h2 style="display:inline">Data Points</h2>
<button id="adddata" class="btn btn-primary" style="display:inline;">Update data</button>
</div>
<div id="map-canvas"></div>
<hr/>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script>
jQuery(document).ready(function ($) {

  var getIcon = function (color) {
      var pinColor = color;
      var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
      new google.maps.Size(21, 34),
      new google.maps.Point(0, 0),
      new google.maps.Point(10, 34));
      var pinShadow = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_shadow",
      new google.maps.Size(40, 37),
      new google.maps.Point(0, 0),
      new google.maps.Point(12, 35));
      return {
          image: pinImage,
          shadow: pinShadow
      };


  };
  var mapProp = {
      center: new google.maps.LatLng(71.285044, -156.7818778),
      zoom: 10,
      mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(document.getElementById("map-canvas"), mapProp);
  var addMarker = function (lat, lon, color) {
      var position = new google.maps.LatLng(lat, lon);
      var icon = getIcon(color);
      var marker = new google.maps.Marker({
          icon: icon.image,
          shadow: icon.shadow,
          position: position,
          animation: google.maps.Animation.DROP
      });
      marker.setMap(map);
  };
  var addMarkers = function (markers) {
      $.each(markers, function (i, v) {
          window.setTimeout(function () {
              addMarker(v[0], v[1], v[2]);
          }, i * 400);
      });
      console.log('adding markers');

  };
  var data = [
      [71.283, -156.790, "6EF569"],
      [71.273, -156.761, "FE75F9"],
      [71.253, -156.810, "6E5F69"],
      [71.223, -156.851, "BEF5F2"]
  ];
  var moredata = [

      [71.283, -156.990, "FE75F9"],
      [71.273, -156.961, "6EF569"],
      [71.263, -156.910, "BEF5F2"],
      [71.213, -156.951, "6E5F69"]

  ];

  $("#adddata").click(function () {

      addMarkers(moredata);
  });
  window.setTimeout(function () {

      // get this data from somewhere 
      // like a db call or a client window
      addMarkers(data);

  }, 1000);

  });

</script>
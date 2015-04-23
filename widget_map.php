<?php
/**
Template Name: Widget-Map


*/
?>
<style>


#map-canvas {
	height: 500px;
	width: 100%;
}

@media ( min-width : 1200px) .container {
	//
	width :100%;
}
</style>
<div id="map-canvas"></div>
<hr/>
<script src="https://maps.googleapis.com/maps/api/js"></script>

<script>

  jQuery(document).ready(function($) {
        /**
         * calling template should supply the properties, the initial data, and the data updates. 
         *
         */
         // crude export for now
		window.ait = new Object();
        
        // use window signals to run the update callback
        window.ait['makeMap'] = function(data,props) {

          var getIcon = function(color) {
            var pinColor = color;
            var pinImage = new google.maps.MarkerImage(
                "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
                new google.maps.Size(21, 34), new google.maps.Point(0, 0), new google.maps.Point(10, 34));
            var pinShadow = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_shadow",
                new google.maps.Size(40, 37), new google.maps.Point(0, 0), new google.maps.Point(12, 35));
            return {
              image : pinImage,
              shadow : pinShadow
            };

          };
         
          var map = new google.maps.Map(document.getElementById("map-canvas"), props);
          var addMarker = function(lat, lon, color) {
            var position = new google.maps.LatLng(lat, lon);
            var icon = getIcon(color);
            var marker = new google.maps.Marker({
              icon : icon.image,
              shadow : icon.shadow,
              position : position,
              animation : google.maps.Animation.DROP
            });
            marker.setMap(map);
          };
          // need to call this several times...
          var addMarkers = function(markers) {
            $.each(markers, function(i, v) {
              window.setTimeout(function() {
                addMarker(v[0], v[1], v[2]);
              }, i * 400);
            });
            console.log('adding markers');

          };

          var moredata = [

          [ 71.283, -156.990, "FE75F9" ], [ 71.273, -156.961, "6EF569" ], [ 71.263, -156.910, "BEF5F2" ],
              [ 71.213, -156.951, "6E5F69" ]

          ];

          $("#adddata").click(function() {
         
           	var e = $.Event('makeMap');
	        $(this).trigger(e,{update:moredata});
         //   addMarkers(moredata);
          });
          var addsignal = "makeMap";
          $(document).on(addsignal, function (e,d) {
            console.log(addsignal);
            console.log("hi there napwid");
            console.log(d);
            addMarkers(d.update);
        });
          window.setTimeout(function() {

            // get this data from somewhere 
            // like a db call or a client window
            addMarkers(data);

          }, 1000);
        }
        
       
      });
</script>


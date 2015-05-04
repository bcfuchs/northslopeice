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
          $(document).data('map',map);
          var addMarker = function(lat, lon, color,cb) {
            var position = new google.maps.LatLng(lat, lon);
            var icon = getIcon(color);
            var marker = new google.maps.Marker({
              icon : icon.image,
              shadow : icon.shadow,
              position : position,
              animation : google.maps.Animation.DROP
            });
            google.maps.event.addListener(marker, 'click', function() {
             // reset the last one clicked 
              if ($(document).data('last_clicked_marker')) {
                $(document).data('last_clicked_marker').setIcon( $(document).data('last_clicked_marker_icon'));
              }
         	// store the marker and its icon so we can reset...
              
         	  
              (function(marker){
                $(document).data('last_clicked_marker',marker);
              	$(document).data('last_clicked_marker_icon',marker.icon.url);
	            console.log("sotre icon");
              	console.log(marker.icon.url);
              })(marker);
              // use red as the focus icon
              marker.setIcon('http://maps.google.com/mapfiles/ms/icons/red-dot.png')	
          	  console.log(marker.icon);
          	  cb();
            });
            $(document).data('last_marker',marker);
            marker.setMap(map);
          };
          
          // need to call this several times...
          var addMarkers = function(markers) {
            $.each(markers, function(i, v) {
              window.setTimeout(function() {
                // onclick callback
                var cb; 
                if (v[3]) {
               				 cb = v[3];
                }
                else {
                  cb = function(){}
                }
         
                addMarker(v[0], v[1], v[2],cb);
              }, i * 400);
              
            });
           
            
            console.log('adding markers');

          };

          /**
          signal for updating data on map
          */
          
          var addsignal = "makeMap";
          $(document).on(addsignal, function (e,d) {
          
       
           if (d.update) {
            	addMarkers(d.update);
           }
            if (d.resize) {
              
              google.maps.event.trigger( map, 'resize' );
            }
        });
          window.setTimeout(function() {

            // get this data from somewhere 
            // like a db call or a client window
            addMarkers(data);

          }, 1000);
        }
        
       
      });
</script>


<?php
/**
Template Name: Map


*/
?>
<style>
.sidebar-wrap {
	display: none;
}

.gmnoprint img {
	max-width: none;
}

#comments {
	display: none;
}
.show_map_image {
width: 400px;
display:inline !important;

}
html {
	height: 100%
}

body {
	height: 100%;
	margin: 0;
	padding: 0
}

#map-header {
	margin-bottom: 10px;
	width: 500px;
}

#adddata {
	margin-left: 40px;
	margin-bottom: 10px;
}

@media ( min-width : 1200px) .container {
	//
	width
	:
	 
	100%;
}
</style>
<div id="map-header" style="display: inline">
	<h2 style="display: inline;padding-left:10px;">Data Points...click on a point to see its image.</h2>
	<button id="adddata" class="btn btn-primary" style="display: none;">Update data</button>
</div>
<div class="container">
<div class="row">
<div class="col-md-8">
<?php get_template_part('widget_map'); ?>
</div>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/exif.js"></script>
<div class="col-md-4">
<div id="hide-images"></div>
</div>
</div>
</div>
<script>
// update data function
!function() {
  jQuery(document).ready(function($){
    /**
    * Refactor:
    * move to widget_map
    * Button with class "more_data" will populate map with 
    *  with data supplied in attribute data-nsi-mapdata. 
    */
    var moredata = [

        [ 71.283, -156.990, "FE75F9" ], [ 71.273, -156.961, "6EF569" ], [ 71.263, -156.910, "BEF5F2" ],
            [ 71.213, -156.951, "6E5F69" ]

        ];

        $("#adddata").click(function() {
       
         	var e = $.Event('makeMap');
       		$(this).trigger(e,{update:moredata});
       //   addMarkers(moredata);
        });
  });
  
  
}();
  !function() {
		var nsi_datapoints = [];
<?php 
	global $wpdb;
	$query1 = 'select guid  from wp_posts inner join wp_postmeta on wp_posts.id=wp_postmeta.post_id where wp_postmeta.meta_key="be_kestrel_transcribe" and wp_postmeta.meta_value=1';
	$kestrels = $wpdb->get_results($query1);

	$query2 = 'select guid  from wp_posts inner join wp_postmeta on wp_posts.id=wp_postmeta.post_id where wp_postmeta.meta_key="be_ice_photo" and wp_postmeta.meta_value=1';
	$ice = $wpdb->get_results($query2);

	foreach ($ice as $i) {
		echo 'nsi_datapoints.push({type:"ice",url:"'.$i->guid.'"});'."\n";
	}
	foreach ($kestrels as $i) {
		echo 'nsi_datapoints.push({type:"kestrel",url:"'.$i->guid.'"});'."\n";
}

?>
  
    var parseDMS = function(dms) {

      // and convert to decimal degrees...
      var deg;
      switch (dms.length) {
      case 3: // interpret 3-part result as d/m/s
        deg = dms[0] / 1 + dms[1] / 60 + dms[2] / 3600;
        break;
      case 2: // interpret 2-part result as d/m
        deg = dms[0] / 1 + dms[1] / 60;
        break;
      case 1: // just d (possibly decimal) or non-separated dddmmss
        deg = dms[0];
        // check for fixed-width unseparated format eg 0033709W
        //if (/[NS]/i.test(dmsStr)) deg = '0' + deg;  // - normalise N/S to 3-digit degrees
        //if (/[0-9]{7}/.test(deg)) deg = deg.slice(0,3)/1 + deg.slice(3,5)/60 + deg.slice(5)/3600;
        break;
      default:
        return NaN;
      }
      //      if (/^-|[WS]$/i.test(dmsStr.trim())) deg = -deg; // take '-', west and south as -ve

      return Number(deg);
    };
    var toPrec = function(n, places) {
      var f = Math.pow(10, places);
      return Math.round(n * f) / f;
    }
    jQuery(document).ready(function($) {
      var colors = {
        'kestrel' : "6EF569",
        'ice' : "FE75F9"
      }

      var add_data2map = function() {
        var out = [];
        var ids = [];
        for (var i = 0; i < nsi_datapoints.length; i++) {
          // get lat lon
          var url = nsi_datapoints[i].url;
          var type = nsi_datapoints[i].type;

          var id = "nsi_datapoint_" + i;
          $('#hide-images').append('<img id="'+id+'" src="'+url+'"/>');
          ids.push({id:id,type:type});
          $("#"+ ids[i].id).css({display:'none'});
        }
        console.log(ids);
        for (var i = 0; i < ids.length; i++) {

          (function(i,type) {
            $(document.getElementById(ids[i].id)).on('load', function() {
              var img = document.getElementById(ids[i].id);
              console.log(i);
              EXIF.getData(img, function() {
                var lat = EXIF.getTag(img, "GPSLatitude")
                var lon = EXIF.getTag(img, "GPSLongitude")
                if (lat) {
                var newLat = parseDMS(lat);
                var newLon = -1 * parseDMS(lon);
                lat = toPrec(newLat, 4);
                lon = toPrec(newLon, 4);
              
                var cb = function(){
                  if ($(document).data('last_image')) {
                    $(document).data('last_image').removeClass("show_map_image");
                    
                  }
                	$("#"+ ids[i].id).addClass("show_map_image"); 
                	
                	$(document).data('last_image',$("#"+ ids[i].id));
                
                  }
                var data = [[ lat, lon, colors[ids[i].type],cb ]];
                var e = $.Event('makeMap');
                console.log(data);
                $(document).trigger(e, {
                  update : data,
                 
                });
                }

              });
            });
          })(i);

        }

      };

      var mapProp = {
        center : new google.maps.LatLng(71.275044, -156.657915),
        zoom : 9,
        mapTypeId : google.maps.MapTypeId.ROADMAP
      };
      window.ait.makeMap([], mapProp);
      
      google.maps.event.addListenerOnce($(document).data('map'), 
          	'idle', function() {
        // do something only the first time the map is loaded 
     			 add_data2map();
     	
      });
      window.setTimeout(function(){
        var marker = $(document).data('last_marker');
      google.maps.event.trigger(marker, 'click');
        console.log("HIHIHI");
        
      }
      ,3000);
    
  
    var moredata = [

                    [ 71.283, -156.990, "FE75F9" ], [ 71.273, -156.961, "6EF569" ], [ 71.263, -156.910, "BEF5F2" ],
                        [ 71.213, -156.951, "6E5F69" ]

                    ];

                    $("#adddata").click(function() {
                   
                     	var e = $.Event('makeMap');
          	        $(this).trigger(e,{update:moredata});
                   //   addMarkers(moredata);
                    });
    });
  }();
</script>

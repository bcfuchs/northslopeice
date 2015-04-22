<?php
/**
Template Name: Transcriber
*/
?>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/exif.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/geopoint.js"></script>
<style>
/*  override theme settings...*/
.content-left-wrap {
	padding-top: 0 !important;
}

header.entry-header {
	display: none;
}

#plans {
	display: none;
}

#plan-title:hover {
	text-decoration: underline;
	cursor: pointer;
}

#map-canvas {
	height: 300px !important;
	width: 300px !important;
}

#plan { //
	display: none;
}

#kestrel-row .col-md-1:hover {
	cursor: pointer;
	border: 2px solid blue;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	border-color: #9ecaed;
	box-shadow: 0 0 10px #9ecaed;
	-webkit-transition: all 1s ease;
}

.sidebar-wrap {
	display: none;
}

#input-widget .kestrel-image {
	padding: 10px; //
	width: 30px;
}

#kcont {
	margin-top: 150px;
}

#input-widget {
	position: absolute;
	padding: 5px 35px 5px 5px;
	background: gray;
	color: white;
	top: 70px;
	left: 780px;
	z-index: 99999;
	height: 380px;
	width: 230px;
	display: none;
	border: 2px solid blue;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	border-color: #9ecaed;
	box-shadow: 0 0 10px #9ecaed;
	-webkit-transition: all 1s ease;
}

#comments {
	display: none;
}
</style>
<script>
<?php get_currentuserinfo();
		global $current_user;?>

		
	
	
	
var trans_user_login =	"<?php echo $current_user->user_login;?>";
var trans_user_firstname =	"<?php echo $current_user->user_firstname;?>
  ";

  jQuery(document).ready(
      function($) {
			
        var data = [ [ 71.283, -156.790, "6EF569" ], [ 71.273, -156.761, "FE75F9" ], [ 71.253, -156.810, "6E5F69" ],
            [ 71.223, -156.851, "BEF5F2" ] ];
        
        var post_kestrel_data = function(success,error) {
      		
    		data = $("#kestrel-form").serialize();
    		console.log("posting data...");
    	    var ajaxurl = "/wp-admin/admin-ajax.php"
    			
    			$.ajax({
    			    url:ajaxurl, 
    			    data:data, 
    			    success:success,
    				error: error,
    			});
        };
     

        var get_latlon = function(id,cb) {
         console.log(id);
           var lat,lon;
           var img = document.getElementById(id);
          
           EXIF.getData(img, function() {
             		console.log(img);
              		lat = EXIF.getTag(img, "GPSLatitude");
              		lon = EXIF.getTag(img, "GPSLongitude");
              		console.log("lat = " + lat);
              		console.log("lon = "+ lon);
              		cb(lat,lon);
            	});
           
	         
        };
	    var set_latlon_info = function(id) {
		      
		    
	       var addLatLon = function(lat,lon) {
	          console.log(typeof(lat));
	          console.log("alat = " + lat);
        		console.log("a	lon = "+ lon);
        		
	          /// TODO get the negative from the orientation 
	          
	          var str = lat[0] + "° "+ lat[1] + "'"+lat[2] + "\","+ " -"+ lon[0] + "° "+ lon[1] + "' "+lon[2]+"\" ";
	          var geo =  new GeoPoint("-" + lon[0] + "° "+ lon[1] + "' "+lon[2] + "\"", lat[0] + "° "+ lat[1] + "' "+lat[2]+"\" ");
	          console.log(geo.getLatDec());
	          console.log(lon[0] + "° "+ lon[1] + "' "+lon[2]+"\" ");
	          $("#input-widget-info").html(geo.getLatDec().toFixed(3) + "," + geo.getLonDec().toFixed(3));
	          $("#kestrel-form-lat").val(lat[0] + "'"+ lat[1] + "\""+lat[2]);
	          $("#kestrel-form-lon").val(lon[0] + "'"+ lon[1] + "\""+lon[2]);
	          console.log(str);
	          var data = [
	       //               [ 71.283, -156.990, "FE75F9" ]
	                      [geo.getLatDec(), geo.getLonDec(), "6EF569"]
	                     
	                  ];
	         	var e = $.Event('makeMap');
		        $(document).trigger(e,{update:data});
	       
	        }
	       
	        get_latlon(id,addLatLon);
	        	
	       
		      
		      
	      
	    };
        var url = "/wp-content/uploads/2015/04/kestrel.jpg";
        $("#kestrel-row .col-md-1").each(
            function(i, v) {
              var url = "/wp-content/uploads/2015/04/kestrel" + (i + 1) + ".jpg";
              var id = "kestrel" + (i + 1) + "_sel";

              $(v).html('<img id="' + id + '" class="kestrel-image" src="' + url + '"/><div>d ' + (i + 1) + '</div>');
              
              $(v).click(
                  function(e) {
                    $("#input-widget").hide();
                    /*      $(".kestrel-image").css({
                    "display" : "inline"
                    }); */
                    
                    
                    $(this).find("img").hide();
                    set_latlon_info(id);
                    $("#kestrel-form-img").attr('value', $(this).find("img").attr('src'));
                    $("#input-widget-image").html(
                        '<img class="kestrel-image" src="' + url + '"/>');
                   
                    $("#input-widget").show();
                    // show the map

                  });
            });

        $("#submit").click(function(e) {
          
          
          var success = function(response) {
  					alert("Thanks! Your data has been saved!");
  					console.log(response);
  					$("#input-widget").hide();
  					$("#total-kestrels-tr").html(
  						parseInt($("#total-kestrels-tr").html())+1
  					);
  					$("#you-kestrels-tr").html(
    						parseInt($("#you-kestrels-tr").html())+1
    					);
  					
  					$("#you-kestrels-tr").effect( "pulsate", {times:3}, 3000 );
  					$("#total-kestrels-tr").effect( "pulsate", {times:3}, 3000 );
  				
          
          };
          var error = function(e) {
  				  var msg = ": ";
  				  if (! navigator.onLine) {
  				    msg = msg + "You appear to be offline..."
  				    
  				  }
  				  alert(e.statusText+" " + msg);
  				};
          post_kestrel_data(success,error);

        });
        $("#kestrel-form").submit(function() {
          return false;
        });

        $("plan-title").click(function() {
          $("#plan").toggle();
          alert('cl');
        });

      });
</script>
<h3>Click on an image to transcribe it!</h3>
<div class="container">
	<div class="row">
		<div class="col-md-4 panel transcribe-left">
			<?php get_template_part('widget_user');?>
		</div>
		<div class="col-md-8 panel transcribe-right">
			<div id="map-container-1" style="display: none">
				<?php get_template_part('widget_map')?>
				<script>
				jQuery(document).ready(function($){
				  var data = [
				              [71.283, -156.790, "6EF569"],
				              [71.273, -156.761, "FE75F9"],
				              [71.253, -156.810, "6E5F69"],
				              [71.223, -156.851, "BEF5F2"]
				          ];
				  var props = {
				      center : new google.maps.LatLng(71.778044, -156.289),
				      zoom : 7,
				      mapTypeId : google.maps.MapTypeId.ROADMAP
				    };
				    window.ait.makeMap(data,props);
				});
				
				
				</script>
			</div>
		</div>
	</div>
	</div>
	<div class="container" id="kcont">
		<div id="kestrel-row" class="row">
			<div class="col-md-1"></div>
			<div class="col-md-1"></div>
			<div class="col-md-1"></div>
			<div class="col-md-1"></div>
			<div class="col-md-1"></div>
			<div class="col-md-1"></div>
			<div class="col-md-1"></div>
			<div class="col-md-1"></div>
			<div class="col-md-1"></div>
			<div class="col-md-1"></div>
			<div class="col-md-1"></div>
			<div class="col-md-1"></div>
		</div>
	</div>
	<?php get_template_part('widget_transcriber');?>
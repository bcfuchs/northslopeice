<?php
/**
Template Name: Transcriber
*/
?>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/exif.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/geopoint.js"></script>
<style>
/* hide the panels for this page...*/
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

	height: 299px !important;
	width: 280px !important;
	z-index: 9999999;
}
#map-container-1 {
/* 
	position: absolute;
	top: 30px;
	left: 280px; 
	*/
	  margin-top: -39px;
  	margin-left: 410px;


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
	top: 30px;
	left: 580px;
	z-index: 99999;
	height: 580px;
	width: 530px;
	display: none;
	border: 2px solid blue;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	border-color: #9ecaed;
	box-shadow: 0 0 10px #9ecaed;
	-webkit-transition: all 2s ease;
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
        var colors  = ["6EF569","FE75F9", "6E5F69", "BEF5F2","BEA2FA","E5F569"];
        var colorCounter = 0;
        var make_kestrel_data_uri;	
        var data = [ [ 71.283, -156.790, "6EF569" ], [ 71.273, -156.761, "FE75F9" ], [ 71.253, -156.810, "6E5F69" ],
            [ 71.223, -156.851, "BEF5F2" ] ];
        
        var post_kestrel_data = function(success,error) {
      		
    		data = $("#kestrel-form").serialize();
    		
    		console.log("posting data...");
    		console.log(data);
    	    var ajaxurl = "/wp-admin/admin-ajax.php"
    			
    			$.ajax({
    			  	type: $("#kestrel-form").attr('method'),
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
              		var ch = [
				"DateTimeOriginal",
				"DateTimeDigitized",
				"GPSLatitudeRef",
				"GPSLongitudeRef",
				"GPSDateStamp"
				
              		          ];
              	console.log("hiya");	
              	for (var i = 0; i < ch.length;i++) {
              	  var name = ch[i];
              	  console.log(name + ' : ' + EXIF.getTag(img,name));
              	}
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
	          $("#kestrel-form-lat").val(lat[0] + "° "+ lat[1] +  "' "+lat[2]+"\" ");
	          $("#kestrel-form-lon").val(lon[0] + "° "+ lon[1] + "' "+lon[2]+"\" ");
	          console.log(str);
	          
	          var color = colors[colorCounter++];
	          if (colorCounter >= colors.length -1 ) { colorCounter = 0 }
	          var data = [
	                      [geo.getLatDec(), geo.getLonDec(), color]
	                     
	                  ];
		// trigger the map via an event 
		// this is just an update
		// centre is set when map is made
	          var e = $.Event('makeMap');
		        $(document).trigger(e,{update:data,resize:true});
	       
	        	}
	       
	        get_latlon(id,addLatLon);
	        	
	       
		      
		      
	      
	    };
        var url = "/wp-content/uploads/2015/04/kestrel.jpg";
        var images = [];
        <?php
		foreach (get_transcribe_queue() as $img) {	
			// this way no need to worry about comma 
			echo "images.push(\"".$img."\");\n";
	
		}
	
		?>

        $("#kestrel-row .col-md-1").each(
            function(i, v) {
           //   var url = "/wp-content/uploads/2015/04/kestrel" + (i + 1) + ".jpg";
              var url = images.pop();
              var id = "kestrel" + (i + 1) + "_sel";
		      if (url) {
              $(v).html('<img id="' + id + '" class="kestrel-image" src="' + url + '"/><div>d ' + (i + 1) + '</div>');
		      }
              $(v).click(
                  function(e) {
                 // hide widget
                 
                    $("#input-widget").hide();                                                        
                   // $(this).find("img").hide();
                    $("body").data("img",  $(this).find("img"));
                    set_latlon_info(id);
                    $("#kestrel-form-img").attr('value', $(this).find("img").attr('src'));
                    $("#input-widget-image").html(
                        '<img class="kestrel-image" src="' + url + '"/>');
                   
                    $("#input-widget").show();
                    $("#map-container-1").show();
                    
                    // show the map
				
                  });
            });

        $("#submit").click(function(e) {
          
          
          var success = function(response) {
  					alert("Thanks! Your data has been saved!");
  					console.log(response);
  					make_kestrel_data_uri();
  					$("#input-widget").hide();
  					 $("body").data("img").hide();
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

var make_kestrel_anchor = function() {
  
  $("#site-navigation ul").append('<li><a id="kestrel_data_uri" download="kestrel_data64.txt"' 
  
  	+'>Get the Data!</a></li>');
  
}
make_kestrel_data_uri = function(){
var data2 = {
			'action': 'download_data'
			
		};
		
		
	  console.log("testing ajax");
	  $.ajax({url:"/wp-admin/admin-ajax.php",
	    	  data: data2,
	    	  type:"POST",
	    	  success: function(r){
	    	      
	    	  	var d =    btoa(r);
	    	 
	    	 $("#kestrel_data_uri").attr('href', 'data:application/json;charset=utf8;base64,'
	    	   + d);  
	    	   
	    	  	
	    	  },
	    	  error: function(e){console.log("error")}
	    	  });
}
make_kestrel_anchor();
make_kestrel_data_uri();


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
				// only call this when the kestrel button is clicked
				jQuery(document).ready(function($){
				  var data = [				          ];
				  var center = new google.maps.LatLng(71.778044, -156.289);
				  var props = {
				      center : center,
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
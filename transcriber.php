<?php
/**
Template Name: Transcriber
*/
?>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/exif.js"></script>
<style>
#plans {
	display: none;
}

#plan-title:hover {
	text-decoration: underline;
	cursor: pointer;
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
	margin-top: 200px;
}

#input-widget {
	position: absolute;
	padding: 5px 35px 5px 5px;
	background: gray;
	color: white;
	top: 70px;
	left: 600px;
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

        var get_latlon = function(id,cb) {
         console.log(id);
           var lat,lon;
           var img = document.getElementById(id);
          
           EXIF.getData(img, function() {
             		console.log(img);
              		lat = EXIF.getTag(img, "GPSLatitude");
              		lon = EXIF.getTag(img, "GPSLongitude");
              		console.log(lat);
              		console.log(lon);
              		cb(lat,lon);
            	});
           
	         
        };
	    var set_latlon_info = function(id) {
		      
		    
	          var addLatLon = function(lat,lon) {
	          console.log(typeof(lat));
	          /// TODO get the negative from the orientation 
	          var str = lat[0] + "'"+ lat[1] + "\""+lat[2] + ", -" + lon[0] + "'"+ lon[1] + "'"+lon[2];
	          $("#input-widget-info").html(str);
	          console.log(str);
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
                    $("#input-widget-image").html(
                        '<img class="kestrel-image" src="' + url + '"/>');
                   
                    $("#input-widget").show();

                  });
            });

        $("#submit").click(function(e) {
          alert("do something with this data");
          $("#input-widget").hide();

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
<h2>Transcriber</h2>
<h4>
	Hi,
	<?php echo $current_user->user_firstname;?>
	!
</h4>
<div id="plans">
	<h4 id="plan-title">The Plan</h4>
	<ul id="plan" class="list-group">
		<li class="list-group-item">Display kestrel photos waiting to be transcribed in a grid</li>
		<li class="list-group-item">Click on photo--> input page for that photo</li>
		<li class="list-group-item">Save the data and remove kestrel from grid.</li>
		<li class="list-group-item">Mock up example below...</li>
	</ul>
</div>
<div class="container" id="kcont">
	<h3>Click on an image to transcribe it!</h3>
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

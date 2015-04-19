<?php
/**
Template Name: Transcriber
*/
?>
<style>

#plans {
display: none;

}
#plan-title:hover {
	text-decoration: underline;
	cursor: pointer;

}

#plan {
	//display:none;
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
	padding: 10px;
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
  jQuery(document).ready(function($) {
    var data = [
                [71.283, -156.790, "6EF569"],
                [71.273, -156.761, "FE75F9"],
                [71.253, -156.810, "6E5F69"],
                [71.223, -156.851, "BEF5F2"]
            ];
  
    var url = "/wp-content/uploads/2015/04/kestrel.jpg";
    $("#kestrel-row .col-md-1").each(function(i, v) {
      var url = "/wp-content/uploads/2015/04/kestrel"+(i+1)+".jpg";
      $(v).html('<img class="kestrel-image" src="'+url+'"/><div>d ' + (i + 1) + '</div>');
      $(v).attr("data-kestrel-geo",'{\"lat\":'
        					+data[0][0]
      						+',\"lon\":'
      						+data[0][1]
      						+',\"color\":\"'
      						+data[0][2]
      						+'\"}');
      
      $(v).click(function(e) {
        $("#input-widget").hide();
   /*      $(".kestrel-image").css({
          "display" : "inline"
        }); */
        var geo = JSON.parse($(this).attr("data-kestrel-geo"));
        console.log(geo.lat);
        $(this).find("img").parent().html("&nbsp;");
        $("#input-widget-image").html('<img class="kestrel-image" src="'+url+'"/><div>d ' + (i + 1) + '</div>');
        $("#input-widget").show();
        

      });
    })

    $("#submit").click(function(e) {
	  
      alert("do something with this data")
      $("#input-widget").hide();

    });
    $("#kestrel-form").submit(function(){return false;});
    
    $("plan-title").click(function(){ $("#plan").toggle(); alert('cl');});
  
  });
</script>
<h2>Transcriber Widget</h2>
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
	<h3>Click on an image to edit it!</h3>
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
<div id="input-widget">
	<div id="input-widget-image"></div>
	<form id="kestrel-form" action="" class="form-horizontal" style="width: 80%">
		<div class="form-group">
			<div class="col-md-4 field-label">
				<label for="id_reference">Wind Direction</label>
			</div>
			<div class="col-md-4">
				<input id="id_reference" maxlength="255" name="reference" type="text" />
			</div>
		</div>
		<div id="submit-group" class="form-group">
			<label class="col-md-4 control-label" for="submit">Submit</label>
			<div class="col-md-4">
				<button id="submit" name="submit" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</form>
	
</div>
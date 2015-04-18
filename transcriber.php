<?php
/**
Template Name: Transcriber
*/
?>
<style>
#plan-title {
	text-decoration: underline;

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
	left: 900px;
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
    var url = "/wp-content/uploads/2015/04/kestrel.jpg";
    $("#kestrel-row .col-md-1").each(function(i, v) {

      $(v).html('<img class="kestrel-image" src="'+url+'"/><div>d ' + (i + 1) + '</div>');
      $(v).click(function(e) {
        $("#input-widget").hide();
        $(".kestrel-image").css({
          "display" : "inline"
        });
        $(this).find("img").css({
          "display" : "none"
        });
        $("#input-widget-image").html('<img class="kestrel-image" src="'+url+'"/><div>d ' + (i + 1) + '</div>');
        $("#input-widget").show();

      });
    })

    $("#submit").click(function(e) {
	  
      alert("do something with this data")
      $("#input-widget").hide();

    });
    
    $("plan-title").click(function(){ $("#plan").toggle(); });
  
  });
</script>
<h2>Transcriber Widget</h2>
<h4 id="plan-title">The Plan</h4>
<ul id="plan" class="list-group">
	<li class="list-group-item">Display kestrel photos waiting to be transcribed in a grid</li>
	<li class="list-group-item">Click on photo--> input page for that photo</li>
	<li class="list-group-item">Save the data and remove kestrel from grid.</li>
	<li class="list-group-item">Mock up example below...</li>
</ul>
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
	<form action="" class="form-horizontal" style="width: 80%">
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
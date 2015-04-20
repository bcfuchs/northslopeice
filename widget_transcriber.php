<?php
/**
Template Name: Widget_Transcriber
*/
?>
<div id="input-widget">
	
		<div id="input-widget-image"></div>
		<div id="input-widget-info"></div>
		
		<div  id="input-widget-form">
			<form id="kestrel-form" action="" class="form-horizontal" style="width: 80%">
			<input id="kestrel-form-img" type="hidden" name="img"/>
			<input id="kestrel-action" type="hidden" name="action" value="save_kestrel_data"/>
			<input id="kestrel-form-lat" type="hidden" name="lat"/>
			<input id="kestrel-form-lon" type="hidden" name="lon"/>
			<input id="kestrel-form-temp" type="hidden" name="temp" value="-10"/>
			<input id="kestrel-form-wind_speed" type="hidden" name="wind_speed" value="2"/>
				<div class="form-group">
					<div class="col-md-4 field-label">
						<label for="wind_direction">Wind Direction</label>
					</div>
					<div class="col-md-4">
						<input id="wind_direction" maxlength="255" name="wind_direction" type="text" />
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
		<div class="row" id="exif-data"></div>
	</div>

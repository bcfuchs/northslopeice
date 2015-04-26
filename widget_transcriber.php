<?php
/**
Template Name: Widget_Transcriber

called from transcriber.php js
*/
?>
<div id="input-widget">
	<div id="input-widget-image"></div>
	<div id="input-widget-info"></div>
	<div id="input-widget-form">
		<form id="kestrel-form" action="" class="form-horizontal" style="width: 80%" method="POST">
<!--  set from calling template via js -->
			<input id="kestrel-form-img" type="hidden" name="img" /> 
			<input id="kestrel-action" type="hidden" name="action"
				value="save_kestrel_data" /> 
				<input id="kestrel-form-lat" type="hidden" name="lat" /> 
				<input id="kestrel-form-lon"	type="hidden" name="lon" /> 
				 
			

			<div class="form-group">
				<div class="col-md-4 field-label">
					<label for="wind_direction">Wind Direction</label>
				</div>
				<div class="col-md-4">
					<select id="wind_direction" name="wind_direction">
						<option value="--" selected>--</option>
						<option value="N">N</option>
						<option value="NNE">NNE</option>
						<option value="NE">NE</option>
						<option value="E">E</option>
						<option value="ESE">ESE</option>
						<option value="SE">SE</option>
						<option value="SSE">SSE</option>
						<option value="S" selected>S</option>
						<option value="SSW">SSW</option>
						<option value="SW">SW</option>
						<option value="WSW">WSW</option>
						<option value="W">W</option>
						<option value="WNW">WNW</option>
						<option value="NW">NW</option>
						<option value="NNW">NNW</option>
					</select>
				</div>
			</div>
		
		
		
		<?php do_action('k_get_spinner', "Wind Speed", "wind_speed",2); ?>
		<?php do_action('k_get_spinner', "temp", "Temp",-2); ?>		
	<div id="submit-group" class="form-group">
		<div class="col-md-4">
			<button id="submit" name="submit" class="btn btn-primary">Submit</button>
		</div>
	</div>
	</form>
</div>
<div class="row" id="exif-data"></div>
</div>

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
		<div class="row" id="exif-data"></div>
	</div>

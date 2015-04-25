
<style>
.spinner {
	width: 100px;
}

.spinner input {
	text-align: right;
}

.input-group-btn-vertical {
	position: relative;
	white-space: nowrap;
	width: 1%;
	vertical-align: middle;
	display: table-cell;
}

.input-group-btn-vertical>.btn {
	display: block;
	float: none;
	width: 100%;
	max-width: 100%;
	padding: 8px;
	margin-left: -1px;
	position: relative;
	border-radius: 0;
}

.input-group-btn-vertical>.btn:first-child {
	border-top-right-radius: 4px;
}

.input-group-btn-vertical>.btn:last-child {
	margin-top: -2px;
	border-bottom-right-radius: 4px;
}

.input-group-btn-vertical i {
	position: absolute;
	top: 0;
	left: 4px;
}
</style>
<script>
  (function($) {
    $(document).ready(function() {
      $('.spinner .btn:first-of-type').on('click', function() {
        $('.spinner input').val(parseInt($('.spinner input').val(), 10) + 1);
      });
      $('.spinner .btn:last-of-type').on('click', function() {
        $('.spinner input').val(parseInt($('.spinner input').val(), 10) - 1);
      });
    });
  })(jQuery);
</script>
<div class="form-group">
	<div class="col-md-4 field-label">
		<label for="wind_speed">Wind Speed</label>
	</div>
	<div class="col-md-4">
		<div class="input-group spinner">
			<input type="text" name="<?php echo $number_spinner_id ?>" id="<?php echo $number_spinner_id ?>" class="form-control" value="<?php echo $number_spinner_default_value?>">
			<div class="input-group-btn-vertical">
				<button class="btn btn-default">
					<i class="fa fa-caret-up"></i>
				</button>
				<button class="btn btn-default">
					<i class="fa fa-caret-down"></i>
				</button>
			</div>
		</div>
	</div>
</div>

<?php $get_hours_range = get_hours_range(); ?>
<section class="text-center">
	<h4>Edit <?=getStaffName($staff_id); ?>'s Hours</h4>
	<p><?php echo date("l, j M Y",strtotime($date)); ?></p>
</section>
<input type="hidden" name="day" value="<?=$day?>">
<input type="hidden" name="week_day_date" value="<?=$date?>">
<input type="hidden" name="staff_id" value="<?=$staff_id?>">
<input type="hidden" name="business_id" value="<?=$business_id?>">
<input type="hidden" value="" class="repeatAction" name="repeatAction">
<div class="row form-group">
	<input type="hidden" name="is_break[]" value="0">
	<input type="hidden" placeholder="Break Name" class="form-control" name="break_name[]" required="required">
	<div class="col-sm-4">
		<label class="control-label"><b>SHIFT START</b></label>
		<select class="form-control" required="required" name="start_hours[]">
			<?php
			foreach ($get_hours_range as $key => $value): ?>
			<option <?= ($key=="09:00:00")?"selected":""; ?> value="<?=$key?>"><?= $value; ?></option>
			<?php endforeach ?>
		</select>
	</div>
	<div class="col-sm-4">
		<label class="control-label"><b>SHIFT END</b></label>
		<select class="form-control" required="required" name="end_hours[]">
			<?php
			foreach ($get_hours_range as $key => $value): ?>
			<option <?= ($key=="17:00:00")?"selected":""; ?> value="<?=$key?>"><?= $value; ?></option>
			<?php endforeach ?>
		</select>
	</div>
	<div class="col-sm-4">
		<label class="control-label"><b>Location</b></label>
		<select class="form-control" required="required" name="location[]">
			<?php
			foreach ($locations as $key => $value): ?>
			<option <?= ($value['id']==$location_id)?"selected":""; ?> value="<?=$value['id']?>"><?= $value['location_name']; ?></option>
			<?php endforeach ?>
		</select>
	</div>
</div>
<div class="new_contnet">
	
</div>
<div class="row">
	<div class="form-group btn-group col-md-12" style="width: 100%;">
		<button type="button" class="btn btn-default btn-block" onclick="AddShift()" style="margin-top: 0px">+ Add Another Shift</button>
		<button type="button" onclick="AddBreak()" class="btn btn-default btn-block" style="margin-top: 0px">+ Add Break</button>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<label class="control-label"><b>REPEATS</b></label>
		<select name="repeat" class="form-control" required="required" onchange="setSpecificDate(this.value)">
			<option value="0">Don't repeat</option>
			<option value="1">Repeat (Weekly)</option>
			<option value="2">Repeat (Specific Date)</option>
		</select>
	</div>
	<div class="col-md-6 specific_date" style="display: none;">
		<label class="control-label"><b>Date</b></label>
		<input type="text" name="end_repeat_date" class="form-control datepicker" name="">
	</div>
</div>
<?php 
	$loc = "";
	$start_hours = "";
	$end_hours = "";
	foreach ($locations as $key => $value) {
		$loc .= "<option value='".$value['id']."'>".$value['location_name']."</option>";
	}

	foreach ($get_hours_range as $key => $value) {
		$sh = ($key=="18:00:00")?"selected":"";
		$eh = ($key=="22:00:00")?"selected":"";
		$start_hours .= "<option ".$sh." value='".$key."'>".$value."</option>";
		$end_hours .= "<option ".$eh." value='".$key."'>".$value."</option>";
	}
?>
<script type="text/javascript">
	var loc = "<?php echo $loc; ?>"
	var start_hours = "<?php echo $start_hours; ?>"
	var end_hours = "<?php echo $end_hours; ?>"
	var x=0;
	function AddShift(){
		var content = '<div class="row form-group rmappend_'+x+'"><input type="hidden" name="is_break[]" value="0"><input type="hidden" placeholder="Break Name" class="form-control" name="break_name[]" required="required"><div class="col-sm-4"><select class="form-control" required="required" name="start_hours[]">'+start_hours+'</select></div><div class="col-sm-4"><select class="form-control" required="required" name="end_hours[]">'+end_hours+'</select></div><div class="col-sm-4"><select class="form-control" required="required" name="location[]">'+loc+'</select><button onclick="deleteThis('+x+')" type="button" class="btn btn-pure btn-info icon md-close-circle waves-effect waves-classic btn_close"></button></div></div>';
		$(".new_contnet").append(content);
		x++;
	}

	function AddBreak(){
		var content = '<div class="row form-group rmappend_'+x+'"><input type="hidden" name="is_break[]" value="1"><div class="col-sm-3"><input type="text" placeholder="Break Name" class="form-control" name="break_name[]" required="required"></div><div class="col-sm-3"><select class="form-control" required="required" name="start_hours[]">'+start_hours+'</select></div><div class="col-sm-3"><select class="form-control" required="required" name="end_hours[]">'+end_hours+'</select></div><div class="col-sm-3"><select class="form-control" required="required" name="location[]">'+loc+'</select><button onclick="deleteThis('+x+')" type="button" class="btn btn-pure btn-info icon md-close-circle waves-effect waves-classic btn_close"></button></div></div>';
		$(".new_contnet").append(content);
		x++;
	}

	function deleteThis(id){
		$(".rmappend_"+id).remove();
	}
</script>
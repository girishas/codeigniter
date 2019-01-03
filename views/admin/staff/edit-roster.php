<?php $get_hours_range = get_hours_range(); ?>
<section class="text-center">
	<h4>Edit <?=getStaffName($staff_id); ?>'s Hours</h4>
	<p><?php echo date("l, j M Y",strtotime($date)); ?></p>
</section>
<input type="hidden" name="day" value="<?=$day?>">
<input type="hidden" name="week_day_date" value="<?=$date?>">
<input type="hidden" name="staff_id" value="<?=$staff_id?>">
<input type="hidden" name="business_id" value="<?=$business_id?>">
<input type="hidden" name="is_repeat_old" value="<?=$is_repeat?>">
<input type="hidden" name="common_number" value="<?=$common_number?>">
<input type="hidden" value="" class="repeatAction" name="repeatAction">
<?php
	$i=0;
	foreach ($roster as $key => $value): 
	$col = ($value['is_break']==0)?4:3;
	$display = ($value['is_repeat']==2)?"display:block":"display:none";
	?>
<div class="row form-group rmappend_<?= $i ?>">
	<input type="hidden" name="is_break[]" value="<?=$value['is_break']?>">
	<?php if($col==3): ?>
	<div class="col-sm-<?=$col;?>">
		<input type="text" value="<?=$value['break_name']?>" placeholder="Break Name" class="form-control" name="break_name[]" required="required">
	</div>
	<?php else: ?>
		<input type="hidden" placeholder="Break Name" class="form-control" name="break_name[]">
	<?php endif; ?>	
	<div class="col-sm-<?=$col;?>">
		<?php if($i==0): ?>
		<label class="control-label"><b>SHIFT START</b></label>
		<?php endif ?>
		<select class="form-control" required="required" name="start_hours[]">
			<?php
			foreach ($get_hours_range as $kkey => $vvalue): ?>
			<option <?= ($kkey==$value['start_hours'])?"selected":""; ?> value="<?=$kkey?>"><?= $vvalue; ?></option>
			<?php endforeach ?>
		</select>
	</div>
	<div class="col-sm-<?=$col;?>">
		<?php if($i==0): ?>
		<label class="control-label"><b>SHIFT END</b></label>
		<?php endif ?>
		<select class="form-control" required="required" name="end_hours[]">
			<?php
			foreach ($get_hours_range as $kkey => $vvalue): ?>
			<option <?= ($kkey==$value['end_hours'])?"selected":""; ?> value="<?=$kkey?>"><?= $vvalue; ?></option>
			<?php endforeach ?>
		</select>
	</div>
	<div class="col-sm-<?=$col;?>">
		<?php if($i==0): ?>
		<label class="control-label"><b>Location</b></label>
		<?php endif ?>
		<select class="form-control" required="required" name="location[]">
			<?php
			foreach ($locations as $kkey => $vvalue): ?>
			<option <?= ($vvalue['id']==$value['location_id'])?"selected":""; ?> value="<?=$vvalue['id']?>"><?= $vvalue['location_name']; ?></option>
			<?php endforeach ?>
		</select>
		<?php if($i!=0): ?>
		<button onclick="deleteThis(<?=$i?>)" type="button" class="btn btn-pure btn-info icon md-close-circle waves-effect waves-classic btn_close"></button>
		<?php endif ?>
	</div>
</div>
<?php 
$i++;	
endforeach ?>
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
			<option <?= ($value['is_repeat']==0)?"selected":""; ?> value="0">Don't repeat</option>
			<option <?= ($value['is_repeat']==1)?"selected":""; ?> value="1">Repeat (Weekly)</option>
			<option <?= ($value['is_repeat']==2)?"selected":""; ?> value="2">Repeat (Specific Date)</option>
		</select>
	</div>
	<div class="col-md-6 specific_date" style="<?= $display; ?>">
		<label class="control-label"><b>Date</b></label>
		<input type="text" value="<?= $value['end_repeat_date'];
		 ?>" name="end_repeat_date" class="form-control datepicker">
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
	var x=<?= $i; ?>;
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
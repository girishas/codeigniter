<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
	<!-- <link rel="stylesheet" href="<?php echo base_url('global/css/timepicki.css');?>"> -->
	<!--[if lt IE 8]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('admin/common/navbar'); ?>
	<?php $this->load->view('admin/common/left_menubar'); ?>
	<!-- Page -->
	<div class="page">
		<div class="page-content">
			<div class="panel nav-tabs-horizontal" data-plugin="tabs">
				<div class="page-header">
					<h1 class="page-title">Staff Working Hours</h1>
					<div class="page-header-actions"><a href="<?= base_url('admin/staff') ?>"><button type="button" class="btn btn-block btn-primary waves-effect waves-classic">View All</button></a></div>
				</div>
				<ul class="nav nav-tabs nav-tabs-line" role="tablist">
					<li class="nav-item" style=""><a class="nav-link" href="<?php echo base_url('admin/staff/view/'.$id); ?>"><i class="icon md-home" aria-hidden="true"></i>All Information</a></li>
					<li class="nav-item" style=""><a class="nav-link" href="<?php echo base_url('admin/staff/services/'.$id); ?>"><i class="icon md-account" aria-hidden="true"></i>Services</a></li>
					<li class="nav-item" style=""><a class="nav-link show active" href="<?php echo base_url('admin/staff/working_hours/'.$id); ?>"><i class="icon md-label" aria-hidden="true"></i>Working Hours</a></li>
				</ul>
				<div class="panel-body">
					<div class="tab-content">
						<form method="post">
							<input type="hidden" name="action" value="action">
							
							<!-- <div class="row">
								<div class="col-md-2">
									<div class="checkbox-custom checkbox-info">
										<select   >
										<option data-select2-id="34"></option>
												 <option value="22" data-select2-id="35">Weekly</option>
												 <option selected="" value="14" data-select2-id="3">Today Only</option>
												 <option value="15" data-select2-id="36">Specific Date</option>
																			</select>
									</div>
								</div>
							</div> -->
							
							
							<?php 
							$ii = 0;
							//echo "<pre>",print_r($staff_data);
							$start_hours = null;
							$end_hours = null;
							$location_id = null;
							$check = null;
							$disabled = null;
							$day = null;
							$weeks = array(0=>"Monday",1=>"Tuesday",2=>"Wednesday",3=>"Thursday",4=>"Friday",5=>"Saturday",6=>"Sunday");
						 	//$weeks = array(0=>"Sunday, 28 October 2018");
							foreach ($weeks as $i => $value) {
								if(isset($staff_data[$i]['is_break']) && $staff_data[$i]['is_break']==0 && $staff_data[$i]['week_day']==$i)
								{
									$start_hours = $staff_data[$i]['start_hours'];
									$end_hours = $staff_data[$i]['end_hours'];
									$location_id = $staff_data[$i]['location_id'];
									$check = "checked";
									$disabled = null;
								}else{
									$start_hours = null;
									$end_hours = null;
									$location_id = null;
									$check = null;
									$disabled = "disabled";
								}

							?>
							<div class="row">
								<div class="col-md-2">
									<div class="checkbox-custom checkbox-info">
										<input type="checkbox" <?= $check; ?> class="icheckbox-primary checkbox_<?=$i;?>" id="<?= $value ?>" name="day[]" onchange="validate(<?=$i;?>)" value="<?=$i?>" data-plugin="iCheck" data-checkbox-class="icheckbox_flat-blue"/>
										<label class="label_<?=$i;?>" for="<?= $value ?>" style="font-weight: 500;color: #000;margin-left: 30px;"><?= $value ?></label>
									</div>
								</div>
								<div class="col-md-2">
									<input type="text" <?=$disabled; ?> value="<?= $start_hours; ?>" required="required" class="form-control time_element column_<?=$i;?>" name="start_hours[<?=$i;?>]">
								</div>
								<label class="">To</label>
								<div class="col-md-2">
									<input type="text" <?=$disabled; ?> value="<?= $end_hours; ?>" required="required" class="form-control time_element column_<?=$i;?>" name="end_hours[<?=$i;?>]">
								</div>
								<div class="col-md-3">
									<select required="required" <?=$disabled; ?> class="form-control column_<?=$i;?>" name="location_id[<?=$i;?>]" data-plugin="select2" data-placeholder="Select a Location">
										<option></option>
										<?php
										foreach ($locations as $key => $value) { ?>
										<option <?php echo ($value['id']==$location_id)?"selected":""; ?> value="<?php echo $value['id']; ?>"><?php echo $value['location_name']; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-1 monday">
									<button <?=$disabled; ?> onclick="addWork(<?=$i?>)" type="button" class="btn btn-info btn-sm waves-effect waves-classic column_<?=$i;?>"><i class="icon md-plus" aria-hidden="true"></i>Work</button>
								</div>
								<div class="col-md-1 monday">
									<button <?=$disabled; ?> type="button" onclick="addMonday(<?=$i?>)" class="btn btn-success btn-sm waves-effect waves-classic column_<?=$i;?>"><i class="icon md-plus" aria-hidden="true"></i>Break</button>
								</div>
								<div class="row append_work_<?=$i?>" style="width: 100%;">
									<?php
									if(isset($staff_data[$i]['work'])){
									foreach ($staff_data[$i]['work'] as $key => $value) { 
										$ii = $ii+1;
									?>
	<div class="row mcontent rmappend_<?=$i;?>" style="width:100%;"><div class="col-md-2" style="margin-left:30px;"></div><div class="col-md-2"><input type="text" value="<?=$value['start_hours']?>" required="required" class="form-control time_element" name="work[<?=$i;?>][<?=$key?>][start_hours]"></div><label>To</label><div class="col-md-2"><input type="text" value="<?=$value['end_hours']?>" required="required" class="form-control time_element" name="work[<?=$i;?>][<?=$key?>][end_hours]"></div><div class="col-md-3"><select data-plugin="select2" data-placeholder="Select a Location" required="required" class="form-control locations" name="work[<?=$i;?>][<?=$key?>][location_id]"><option></option>
		<?php
			foreach ($locations as $kkey => $vvalue) { ?>
			<option <?php echo ($vvalue['id']==$value['location_id'])?"selected":""; ?> value="<?php echo $vvalue['id']; ?>"><?php echo $vvalue['location_name']; ?></option>
			<?php } ?>
	</select></div><div class="col-md-1"><button type="button" class="btn btn-icon btn-default waves-effect waves-classic remove_button"><i class="icon md-delete" aria-hidden="true"></i></button></div><br><br></div>
									<?php }
									}
									?>									
								</div>
								<div class="row append_<?=$i?>" style="width: 100%;">
									<?php
									if(isset($staff_data[$i]['break'])){
									foreach ($staff_data[$i]['break'] as $key => $value) { 
										$ii = $ii+1;
									?>
	<div class="row mcontent rmappend_<?=$i;?>" style="width:100%;"><div class="col-md-2" style="margin-left:30px;"><input required="required" value="<?= $value['break_name'] ?>" type="text" class="form-control" name="break[<?=$i;?>][<?=$key?>][break_name]" placeholder="Break name"></div><div class="col-md-2"><input type="text" value="<?=$value['start_hours']?>" required="required" class="form-control time_element" name="break[<?=$i;?>][<?=$key?>][break_start_hours]"></div><label>To</label><div class="col-md-2"><input type="text" value="<?=$value['end_hours']?>" required="required" class="form-control time_element" name="break[<?=$i;?>][<?=$key?>][break_end_hours]"></div><div class="col-md-3"><select data-plugin="select2" data-placeholder="Select a Location" required="required" class="form-control locations" name="break[<?=$i;?>][<?=$key?>][break_location_id]"><option></option>
		<?php
			foreach ($locations as $kkey => $vvalue) { ?>
			<option <?php echo ($vvalue['id']==$value['location_id'])?"selected":""; ?> value="<?php echo $vvalue['id']; ?>"><?php echo $vvalue['location_name']; ?></option>
			<?php } ?>
	</select></div><div class="col-md-1"><button type="button" class="btn btn-icon btn-default waves-effect waves-classic remove_button"><i class="icon md-delete" aria-hidden="true"></i></button></div><br><br></div>
									<?php }
									}
									?>
								</div>
							</div>
						<?php } ?>
						<button type="submit" class="btn btn-primary">Submit</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php 
	$loc = "";

	foreach ($locations as $key => $value) {
		$loc .= "<option value='".$value['id']."'>".$value
		['location_name']."</option>";
	}
	$htmlString= 'testing';
	//echo "here".$ii;die;
	?>
	<script src="<?php echo base_url('global/vendor/jquery/jquery.js');?>"></script>
	<script type="text/javascript">
		var loc = "";
	$(document).ready(function(){
		/*$(".time_element").timepicki({
		show_meridian:false,
		min_hour_value:0,
		max_hour_value:23,
		step_size_minutes:15,
		overflow_minutes:true,
		increase_direction:'up',
		disable_keyboard_mobile: false});*/

		$('.time_element').timepicker();

		loc = "<?php echo $loc; ?>";
		//alert(loc);
	});
	var x = <?php echo $ii; ?>
	//Append Monday
	function addMonday(id){

		var content = '<div class="row mcontent rmappend_'+id+'" style="width:100%;"><div class="col-md-2" style="margin-left:30px;"><input required="required" type="text" class="form-control" name="break['+id+']['+x+'][break_name]" placeholder="Break name"></div><div class="col-md-2"><input type="text" required="required" class="form-control time_element" name="break['+id+']['+x+'][break_start_hours]"></div><label>To</label><div class="col-md-2"><input type="text" required="required" class="form-control time_element" name="break['+id+']['+x+'][break_end_hours]"></div><div class="col-md-3"><select required="required" class="form-control locations" name="break['+id+']['+x+'][break_location_id]"><option></option>'+loc+'</select></div><div class="col-md-1"><button type="button" class="btn btn-icon btn-default waves-effect waves-classic remove_button"><i class="icon md-delete" aria-hidden="true"></i></button></div><br><br></div>';
		$(".append_"+id).append(content);
		/*$(".time_element").timepicki({
		show_meridian:false,
		min_hour_value:0,
		max_hour_value:23,
		step_size_minutes:15,
		overflow_minutes:true,
		increase_direction:'up',
		disable_keyboard_mobile: false});*/
		$('.time_element').timepicker();
		$(".locations").select2({
			placeholder: "Select a Location"
		});
		x++;
	}
	function addWork(id){
		var day = $(".label_"+id).text();
		var content_work = '<div class="row mcontent rmappend_'+id+'" style="width:100%;"><div class="col-md-2" style="margin-left:30px;"></div><div class="col-md-2"><input type="text" required="required" class="form-control time_element" name="work['+id+']['+x+'][start_hours]"></div><label>To</label><div class="col-md-2"><input type="text" required="required" class="form-control time_element" name="work['+id+']['+x+'][end_hours]"></div><div class="col-md-3"><select required="required" class="form-control locations" name="work['+id+']['+x+'][location_id]"><option></option>'+loc+'</select></div><div class="col-md-1"><button type="button" class="btn btn-icon btn-default waves-effect waves-classic remove_button"><i class="icon md-delete" aria-hidden="true"></i></button></div><br><br></div>';
		$(".append_work_"+id).append(content_work);
		/*$(".time_element").timepicki({
		show_meridian:false,
		min_hour_value:0,
		max_hour_value:23,
		step_size_minutes:15,
		overflow_minutes:true,
		increase_direction:'up',
		disable_keyboard_mobile: false});*/
		$('.time_element').timepicker();
		$(".locations").select2({
			placeholder: "Select a Location"
		});
		x++;
	}
	$(document).on('click', '.remove_button', function(){ //Once remove button is clicked
				$(this).parents('.mcontent').remove(); //Remove field html
				/*$(".time_element").timepicki({
		show_meridian:false,
		min_hour_value:0,
		max_hour_value:23,
		step_size_minutes:15,
		overflow_minutes:true,
		increase_direction:'up',
		disable_keyboard_mobile: true});*/
		$('.time_element').timepicker();
			});

	function validate(id){
		if ($(".checkbox_"+id).is(':checked')) {
		    $(".column_"+id).removeAttr("disabled");
		 }else{
		 	$(".column_"+id).attr("disabled","disabled");
		 	$(".column_"+id).val("");
		 	$(".rmappend_"+id).remove();
		 }
	};
	</script>
	<?php $this->load->view('admin/common/footer'); ?>
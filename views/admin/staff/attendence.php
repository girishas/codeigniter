<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
	<!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('admin/common/navbar'); ?>
	<?php $this->load->view('admin/common/left_menubar'); ?>
	<style type="text/css">
		.select2{
		z-index: 2!important;
		}
		.ui-timepicker-wrapper{
		z-index: 99999!important;
		}
	</style>
	<!-- Page -->
	<div class="page">
		<!-- Alert message part -->
		<?php $this->load->view('admin/common/header_messages'); ?>
		<!-- End alert message part -->
		<div class="page-main">
			<div class="page-content">
				<div class="panel panel-bordered">
					<div class="panel-heading" style="padding: 15px;">
						<form method="post">
							<div class="row">
								<input type="hidden" name="action" value="save">
								<?php if($admin_session['role'] !="staff"){?>
									<div class="col-md-2">
										<div class="form-group">
											<label class="control-label">Choose Staff</label>
											<select required="required" name="staff_id" class="form-control" data-plugin="select2">
												<option value="">Choose Staff</option>
												<?php
													$select="";
													foreach ($all_staffs as $key => $value):
													if(isset($post_data) && count((array)$post_data)>0){
														$select = ($post_data['staff_id']==$value['id'])?"selected":"";
													}
												?>
												<option <?=$select;?> value="<?= $value['id']?>"><?=  $value['first_name']." ".$value['last_name'] ?></option>
												<?php endforeach ?>
											</select>
										</div>
									</div>
									<?php }else{ ?>
									<input type="hidden" value="<?=$admin_session['staff_id']?>" name="staff_id">
								<?php } ?>	
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label">Choose Duration</label>
										
										<select onchange="showDates(this.value)" required="required" name="duration" class="form-control" data-plugin="select2">
											<option value="">Choose Duration</option>
											<option <?= ($post_data['duration']==1)?"selected":"";?>  value="1">This Week</option>
											<option <?= ($post_data['duration']==0)?"selected":"";?> value="0">This Month</option>
											<option <?= ($post_data['duration']==3)?"selected":"";?> value="3">3 Months</option>
											<option <?= ($post_data['duration']==6)?"selected":"";?> value="6">6 Months</option>
											<option value="10">Custom Dates</option>
										</select>
									</div>
								</div>
								<div class="col-md-2 sh" style="display: none;">
									<div class="form-group">
										<label class="control-label">Date From</label>
										<input required="required" autocomplete="off" value="<?php echo date('Y-m-01',strtotime(date('Y-m-d'))); ?>" type="text" class="form-control datepicker" name="date_from">
									</div>
								</div>
								<div class="col-md-2 sh" style="display: none;">
									<div class="form-group">
										<label class="control-label">Date To</label>
										<input required="required" autocomplete="off" value="<?= date('Y-m-t',strtotime(date('Y-m-d'))); ?>" type="text" class="form-control datepicker" name="date_to" >
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label">&nbsp;</label><br>
										<button class="btn btn-info">Search</button>
										<!-- <a href="<?= base_url('admin/staff/attendence'); ?>" class="btn btn-info ">Show All</a> -->
									</div>
								</div>
								<?php //if($admin_session['role']!="staff"): ?>
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label">&nbsp;</label><br>
										<button data-target="#exampleFormModal" data-toggle="modal" type="button" class="btn btn-info">Add Attendence</button>
									</div>
								</div>
								<?php //endif ?>
							</div>
						</form>
					</div>
					<div class="panel-body">
						<table class="table table-hover table-bordered" id="example">
							<thead>
								<tr>
									<td class="text-right"><b>Date</b></td>
									<td class="text-right"><b>Day</b></td>
									<td class="text-right"><b>Roster Time</b></td>
									<td class="text-right"><b>Hrs.</b></td>
									<td class="text-right"><b>Attendence Time</b></td>
									<td class="text-right"><b>Hrs.</b></td>
								</tr>
							</thead>
							<?php if (count((array)$attendences)>0): ?>
							<tbody>
								<?php foreach ($attendences as $key => $value): ?>
								<tr>
									<td class="text-right"><?php echo date("j M Y",strtotime($key)); ?></td>
									<td class="text-right"><?php echo date("l",strtotime($key)); ?></td>
									<td class="text-right">
										<?php 
											$roster_data = getRosterForAttendence($post_data['staff_id'],$key);
											if($roster_data){
												foreach ($roster_data as $rkey => $rvalue) {
													echo getLocationNameById($rvalue['location_id'])." ( ". date("h:i a",strtotime($rvalue['start_hours']))?>&nbsp;-&nbsp;<?php echo !empty($rvalue['end_hours'])?date("h:i a",strtotime($rvalue['end_hours'])):"N/A";echo " )<br>";
												}
												}else{
												echo "No Data Found";
											}
										?>
									</td>
									<td class="text-right">
										<?php 
											if($roster_data){
												$total_hr = 0;
												$total_hrs=0;
												foreach ($roster_data as $rkey => $rvalue) {
													if($rvalue['end_hours']!=""){
														$total_hrs = $total_hrs + abs(intval((strtotime($rvalue
														['start_hours'])-strtotime($rvalue
														['end_hours']))/60));
													}
												}
												$hours = intval($total_hrs/60);
												$minutes = intval($total_hrs%60);
												if($hours>0){
													echo $hours."h ";
												}
												if($minutes>0){
													echo $minutes."min";
												}
												}else{
												echo "N/A";
											}
											
										?>
									</td>
									<td class="text-right">
										<?php
											if($value){
												foreach ($value as $kkey => $vvalue) {
													echo getLocationNameById($vvalue['location_id'])." ( ". date("h:i a",strtotime($vvalue['start_hours']))?>&nbsp;-&nbsp;<?php echo !empty($vvalue['end_hours'])?date("h:i a",strtotime($vvalue['end_hours'])):"N/A";echo " )<br>";
												}
												}else{
												echo "No Data Found";
											}
										?>
									</td>
									<td class="text-right">
										<?php 
											if($value){
												$total_hr = 0;
												$total_hrs=0;
												foreach ($value as $kkey => $vvalue) {
													if($vvalue['end_hours']!=""){
														$total_hrs = $total_hrs + abs(intval((strtotime($vvalue
														['start_hours'])-strtotime($vvalue
														['end_hours']))/60));
													}
												}
												$hours = intval($total_hrs/60);
												$minutes = intval($total_hrs%60);
												if($hours>0){
													echo $hours."h ";
												}
												if($minutes>0){
													echo $minutes."min";
												}
												}else{
												echo "N/A";
											}
											
										?>
									</td>
								</tr>
								<?php endforeach ?>
							</tbody>
							<?php endif ?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="exampleFormModal" aria-hidden="false" aria-labelledby="exampleFormModalLabel"
	role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<form class="modal-content" method="post" action="<?= base_url('admin/staff/add_manual_attendence') ?>">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="exampleFormModalLabel">Set The Attendence</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" name="action" value="save">
					<div class="row">
						<?php $get_hours_range = get_hours_range(); ?>
						<div class="col-xl-4 form-group">
							
							<label class="control-label"><b>Date</b></label>
							<input type="text" autocomplete="off" required="required" class="form-control datepicker" name="date" id="date"> 
						</div>
						<div class="col-xl-4 form-group">
							
							<?php if($admin_session['role']=="business_owner"): ?>
								<label class="control-label"><b>Location</b></label>
							<select name="location_id" class="form-control" data-plugin="select2" id="location_val">
								<?php foreach ($locations as $key => $value): ?>
								<option value="<?= $value['id']?>"><?=  $value['location_name'];?></option>
								<?php endforeach ?>
							</select>
							<?php else: ?>
							<input type="hidden" value="<?php echo $admin_session['location_id']; ?>" name="location_id">
							<input type="hidden" value="<?php echo $admin_session['location_id']; ?>" name="location_val">
							<?php endif ?>	
						</div>
					</div>
					
					<div class="alert alert-danger">
						<strong>Note:-</strong>  In order to save attendence all the fields should be filled for a single staff.
					</div>
					
					<table id="example" class="table  table-hover  table-striped w-full" data-plugin="">
						<thead>
							<tr>                    
								<th class="dark-background-heading">STAFF</th>
								<th class="dark-background-heading">SHIFT START</th>
								<th class="dark-background-heading">SHIFT END</th>
							</tr>
						</thead>
						<tbody id="attendence_popup">
							<tr>
									<td colspan="3" >Roster not set for the Staff.</td>
								</tr>
							<?php  if(!empty($staffs)){
							$counter = 1; foreach ($staffs as $key => $value) { ?> 
								<tr>
									<td><?=  $value['first_name']." ".$value['last_name'] ?>
										<input type="hidden"  class="form-control" name="staff_id[]" value="<?php echo $value['id']?>">
									</td> 
									<td><input type="text" autocomplete="off" class="form-control timepicker" name="start_hours[]"></td>
									<td><input type="text" autocomplete="off" class="form-control timepicker" name="end_hours[]"></td>
								</tr>
							<?php $counter++; } 
							} else { ?>
								<tr>
									<td colspan="3" >Roster not set for the Staff.</td>
								</tr>
							<?php } ?>	
						</tbody>
					</table>
					
					
					<!-- <div class="row">						
						<div class="col-xl-4 form-group">
						<label class="control-label"><b>Staff</b></label>
						<input type="text"  class="form-control" name="start_hours" value="<?=  $value['first_name']." ".$value['last_name'] ?>">
						</div>
						
						<div class="col-xl-2 form-group">
						<label class="control-label"><b>START</b></label>
						<input type="text" autocomplete="off" class="form-control timepicker" name="start_hours">
						</div>
						<div class="col-xl-2 form-group">
						<label class="control-label"><b>END</b></label>
						<input type="text" autocomplete="off" class="form-control timepicker" name="end_hours">
						</div>
						
						<div class="col-xl-4 form-group">
						<label class="control-label">Choose Location</label>
						<select name="location_id" required="required" class="form-control" data-plugin="select2">
						<option value="">Choose Location</option>
						<?php foreach ($locations as $key => $value): ?>
						<option value="<?= $value['id']?>"><?=  $value['location_name'];?></option>
						<?php endforeach ?>
						</select>
						</div>
					</div> -->
					
					
					<div class="row">
						<div class="col-md-4 float-right">
							<button class="btn btn-primary btn-outline btn-block" type="submit">Save</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- End Modal -->
	<?php $this->load->view('admin/common/footer'); ?>
	<script type="text/javascript">
		$(document).ready( function() {
			$('.timepicker').timepicker({ 'showDuration': true,
			'timeFormat': 'g:ia','step': 15  });
		});
		$('.timepicker').timepicker({ 'showDuration': true,
							'timeFormat': 'g:ia','step': 15  });
		$(document).ready( function() {
			$('.datepicker').datepicker({
				format:"yyyy-mm-dd",
				todayHighlight:true
			});
			$('#example').dataTable({
				"paging": true,
				dom: 'Bfrtip',
				"order": [],
				"pageLength": 31,
				buttons: [
				'csv','print'
				]
			});
			$('#date').datepicker('setDate', 'today');
			
			
		});
		
		$('#location_val').on('change', function() {
			var location_id = this.value;
			var date_on = $('#date').val();
			
			$.ajax({
				type: 'POST',
				url: site_url + 'admin/staff/add_attendence_popup/'+ encodeURIComponent(date_on)+'/'+encodeURIComponent(location_id),
				datatype: 'json',
				success: function(data)
				{		
						var str = '';
						data = JSON.parse(data);
						if($.trim(data) && data.length>0){
							$.each(data, function(k, v) {
								//alert(v.first_name);
							str = str + '<tr><td>'+v.first_name+' '+v.last_name+' <input type="hidden"  class="form-control" name="staff_id[]" value="'+ v.id +'"></td>';
								if (v.start_hours==undefined) {
									str = str + ' <td><input type="text" autocomplete="off" class="form-control timepicker" name="start_hours[]"></td>';
								}
								else{
									str = str + ' <td><input type="text" autocomplete="off" class="form-control timepicker" readonly name="start_hours[]" value="'+v.start_hours+'"></td>';
								}
								if (v.end_hours==undefined) {
								str = str + '<td><input type="text" autocomplete="off" class="form-control timepicker" name="end_hours[]"></td>';	
								}
								else{
								str = 	str + '<td><input type="text" autocomplete="off" class="form-control timepicker" readonly name="end_hours[]" value="'+v.end_hours+'"></td>';	

								}

								  str =   str + '</tr>';
							});
						}else{
							str = '<tr><td colspan="3">No Staff Rosted for this Location on this Date</td></tr>';
						}
						$("#attendence_popup").html(str);
						$('.timepicker').timepicker({ 'showDuration': true,
							'timeFormat': 'g:ia','step': 15  });
				}
			});
			
			
		});
		$('#date').on('change', function() {
			var date_on  = this.value;
			var  location_id = $('#location_val').val();
			
			$.ajax({
				type: 'POST',
				url: site_url + 'admin/staff/add_attendence_popup/'+ encodeURIComponent(date_on)+'/'+encodeURIComponent(location_id),
				datatype: 'json',
				success: function(data)
				{	
				//alert(data);	
						var str = '';
						data = JSON.parse(data);
						if($.trim(data) && data.length>0){
							$.each(data, function(k, v) {								
								str = str + '<tr><td>'+v.first_name+' '+v.last_name+' <input type="hidden"  class="form-control" name="staff_id[]" value="'+ v.id +'"></td>';
								if (v.start_hours==undefined) {
									str = str + ' <td><input type="text" autocomplete="off" class="form-control timepicker" name="start_hours[]"></td>';
								}
								else{
									str = str + ' <td><input type="text" autocomplete="off" class="form-control timepicker" readonly name="start_hours[]" value="'+v.start_hours+'"></td>';
								}
								if (v.end_hours==undefined) {
								str = str + '<td><input type="text" autocomplete="off" class="form-control timepicker" name="end_hours[]"></td>';	
								}
								else{
								str = 	str + '<td><input type="text" autocomplete="off" class="form-control timepicker" readonly name="end_hours[]" value="'+v.end_hours+'"></td>';	

								}

								  str =   str + '</tr>';
							});
						}else{
							str = '<tr><td colspan="3">No Staff Rosted for this Location on this Date</td></tr>';
						}
						//alert('date'+str);
						$("#attendence_popup").html(str);
					$('.timepicker').timepicker({ 'showDuration': true,
							'timeFormat': 'g:ia','step': 15  });	
				}
			});
			
			
		});
		function showDates(val){
			if (val==10) {
				$(".sh").css("display","block");
				}else{
				$(".sh").css("display","none");
			}
		}
	</script>		
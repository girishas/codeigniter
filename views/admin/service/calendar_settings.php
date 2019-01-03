<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
	<!--[if lt IE 8]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('admin/common/navbar'); ?>
	<?php $this->load->view('admin/common/left_menubar'); ?>
	<!-- Page -->
	<div class="page">
		<div class="page-content">
			<div class="panel">
				<?php $this->load->view('admin/common/header_messages'); ?>
				<div class="page-header">
					<h1 class="page-title">Calendar Settings</h1>
					<div class="page-header-actions">
						<a href="<?php echo base_url('admin/setup');?>"><button type="button" class="btn btn-block btn-primary">Setup</button></a>
						</div>
				</div>
				<div class="page-content container-fluid">
					<div class="row">
						<div class="col-md-6">
							<!-- Panel Static Labels -->
							<?php $get_hours_range = get_hours_range(); ?>
							<form autocomplete="off" method="post" action="">
								<input type="hidden" name="action" value="save">
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Calendar Start time</label>
										<br/>
										<select class="form-control" name="start_time" id="hours">
											 <?php
								              foreach ($get_hours_range as $key => $value): 
								              	$selected = ($settings['start_time'])?$settings['start_time']:"09:00:00";
								              ?>
								              <option <?= ($key==$selected)?"selected":""; ?> value="<?=$key?>"><?= $value; ?> </option>
								            <?php endforeach ?>
										</select>
									</div>
								</div>								
								
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Time slot interval</label>
										<?php $slot = ['00:10:00'=>10,'00:15:00'=>15,'00:20:00'=>20,'00:25:00'=>25,'00:30:00'=>30,'00:40:00'=>40,'00:50:00'=>50,'00:60:00'=>60]; ?>
										<select class="form-control" name="time_slot_interval" id="time_slot_interval">	
											<?php foreach ($slot as $key => $value): 
												$selected = ($settings['time_slot_interval']==$key)?"selected":"";
												?>
												<option <?=$selected?> value="<?=$key?>"><?=$value?>&nbsp;Minutes</option>
											<?php endforeach ?>
										</select>
									</div>
								</div>

								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">New Appointment Color</label>
										<input type="color" value="<?php echo ($settings['new_appointment_color'])?$settings['new_appointment_color']:''; ?>" class="form-control" name="new_appointment_color">
									</div>
								</div>

								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Confirmed Appointment Color</label>
										<input type="color" value="<?php echo ($settings['confirmed_appointment_color'])?$settings['confirmed_appointment_color']:''; ?>" class="form-control" name="confirmed_appointment_color">
									</div>
								</div>

								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Re-Confirmed Appointment Color</label>
										<input type="color" value="<?php echo ($settings['reconfirmed_appointment_color'])?$settings['reconfirmed_appointment_color']:''; ?>" class="form-control" name="reconfirmed_appointment_color">
									</div>
								</div>

								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Arrived Appointment Color</label>
										<input type="color" value="<?php echo ($settings['arrived_appointment_color'])?$settings['arrived_appointment_color']:''; ?>" class="form-control" name="arrived_appointment_color">
									</div>
								</div>

								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Started Appointment Color</label>
										<input type="color" value="<?php echo ($settings['started_appointment_color'])?$settings['started_appointment_color']:''; ?>" class="form-control" name="started_appointment_color">
									</div>
								</div>

								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Completed Appointment Color</label>
										<input type="color"  value="<?php echo ($settings['completed_appointment_color'])?$settings['completed_appointment_color']:''; ?>" class="form-control" name="completed_appointment_color">
									</div>
								</div>	

								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Noshow Appointment Color</label>
										<input type="color" value="<?php echo ($settings['noshow_appointment_color'])?$settings['noshow_appointment_color']:''; ?>" class="form-control" name="noshow_appointment_color">
									</div>
								</div>

								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Cancel</label>
										<input type="color" value="<?php echo ($settings['cancel_appointment_color'])?$settings['cancel_appointment_color']:''; ?>" class="form-control" name="cancel_appointment_color">
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Re Schedule</label>
										<input type="color" value="<?php echo ($settings['reschedule_appointment_color'])?$settings['reschedule_appointment_color']:''; ?>" class="form-control" name="reschedule_appointment_color">
									</div>
								</div>
								<!-- <div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Default view</label>
										<select class="form-control" name="default_view" id="default_view">
											<option value="">Select</option>
											<option value="day">Day</option>
											<option value="week">Week</option>
											<option value="month">Month</option>
										</select>
									</div>
								</div> -->
								
								
								
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-6">
										<button class="btn btn-primary" type="submit">Save</button>
									</div>
								</div>
								
							
							<!-- End Panel Static Labels -->
						</div>


							<div class="col-md-6">
								<br>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-6">	
										<?php $booking_widget_status= $settings['booking_widget_status']==0?"checked":''  ?>
										
							<div class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" id="defaultGroupExample2" name="booking_widget_status" value="0" <?=$booking_widget_status?> >
							<label class="custom-control-label" for="defaultGroupExample2">Confirmed</label>
							</div>
								</div>

									<div class="col-md-6">
									<?php $booking_widget_status= $settings['booking_widget_status']==1?"checked":''  ?>							
									<div class="custom-control custom-radio">
									<input type="radio" class="custom-control-input" id="defaultGroupExample1" name="booking_widget_status" value="1" <?=$booking_widget_status?>>
									<label class="custom-control-label" for="defaultGroupExample1">Pencilled-In </label>
									</div>
								</div>
								

									
								</div>	

							<!-- 	<div class="page-header">
						<h1 class="page-title">Calendar Settings</h1>
						<div class="page-header-actions"></div>
					</div> -->



					</div>	
					</form>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Page -->
	<?php $this->load->view('admin/common/footer'); ?>
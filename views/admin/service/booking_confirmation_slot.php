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
					<h1 class="page-title">Booking Confirmation Slot</h1>
					<div class="page-header-actions"> 
						<a href="<?php echo base_url('admin/setup');?>"><button type="button" class="btn btn-block btn-primary">Setup</button></a> </div>
				</div>
				<div class="page-content container-fluid">
					<!-- <div class="row"> -->
						<!-- <div class="col-md-6"> -->
							<!-- Panel Static Labels -->
							<form autocomplete="off" method="post" action="">
								<input type="hidden" name="action" value="save">
								
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-4">
										<label class="form-control-label" for="inputGrid1">Send Confirmation SMS before of appointment</label>
										<?php $slot = [2=>"2 Hours",4=>"4 Hours",6=>"6 Hours", 8=>"8 Hours",10=>"10 Hours",12=>"12 Hours",14=>"14 Hours",16=>"16 Hours",18=>"18 Hours",20=>"20 Hours",22=>"22 Hours",24=>"24 Hours",26=>"26 Hours",28=>"28 Hours",30=>"30 Hours"]; ?>
										<select class="form-control" name="time" id="time">	
											<?php foreach ($slot as $key => $value): 
												$selected = ($settings['time']==$key)?"selected":"";
												?>
												<option <?=$selected?> value="<?=$key?>"><?=$value?></option>
											<?php endforeach ?>
										</select>
									</div>

									<div class="col-md-4">
										<label class="form-control-label" for="inputGrid1">Send Confirmation Email before of appointment</label>
										<?php $slot = [2=>"2 Hours",4=>"4 Hours",6=>"6 Hours", 8=>"8 Hours",10=>"10 Hours",12=>"12 Hours",14=>"14 Hours",16=>"16 Hours",18=>"18 Hours",20=>"20 Hours",22=>"22 Hours",24=>"24 Hours",26=>"26 Hours",28=>"28 Hours",30=>"30 Hours"]; ?>
										<select class="form-control" name="email_time" id="email_time">	
											<?php foreach ($slot as $key => $value): 
												$selected = ($settings['email_time']==$key)?"selected":"";
												?>
												<option <?=$selected?> value="<?=$key?>"><?=$value?></option>
											<?php endforeach ?>
										</select>
									</div>
									<div class="col-md-4">
										<label class="form-control-label" for="inputGrid1">Today Appointment Sms Send <?php  ?></label>
										
										<select class="form-control" name="today_sms" id="today_sms">
										<option <?php echo ($settings['today_sms']==0)?"selected":""; ?> value="0">Off</option>
										<option <?php echo ($settings['today_sms']==1)?"selected":""; ?>  value="1">On</option>										
										</select>
									</div>


								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-6">
										<button class="btn btn-primary" type="submit">Save</button>
									</div>
								</div>
								
							</form>
							<!-- End Panel Static Labels -->
						<!-- </div> -->
					<!-- </div> -->
				</div>
			</div>
		</div>
	</div>
	<!-- End Page -->
	<?php $this->load->view('admin/common/footer'); ?>
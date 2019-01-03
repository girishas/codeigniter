<?php $this->load->view('admin/common/header'); ?>
<style>
	 
	.form-group{margin-bottom:10px;}
</style>
	
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
		<div class="page-header">
			<ul class="nav nav-tabs" role="tablist">
				
				<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service');?>" >Services</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_service_category');?>" >Service Categories</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_service_group');?>" >Service Group</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_packages');?>" >Packages</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab"  role="tab">Class</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link ""  href="<?php echo base_url('admin/service/all_class_category');?>" >Class Categories</a></li>
			</ul>
			<div class="page-header-actions">
				<a class="btn btn-info" href="<?php echo base_url('admin/service/all_class');?>">All Class</a>
			</div>
		</div>
			<div class="row">
				<div class="col-md-6">
					<div class="panel-body" style="padding: 10px 30px;">
						<!-- <h1 class="page-title">Add Class</h1><hr> -->
						<h1 class="page-title"><?php if($this->uri->segment('4') == '') { echo "Add Class"; } else{ echo "Class Info"; } ?></h1><hr>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel-body" style="padding: 10px 30px;">
						<h1 class="page-title">Service Timing</h1><hr>
					</div>
				</div>
			</div>
			 
			<div class="row">

				<div class="col-md-6">						
						<div class="panel-body container-fluid">
								
								<input type="hidden" name="action" value="save">

								<?php $admin_session = $this->session->userdata('admin_logged_in');
								if($admin_session['role'] == 'owner') { ?>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Business</label>
										<?php if(isset($class_details)) { $business_id = (isset($business_id) && $business_id!='')?$business_id:$class_details[0]['business_id']; } else { $business_id = (isset($business_id) && $business_id!='')?$business_id:''; }?>
										 
											<?php if($all_business){?>
											<?php foreach($all_business as $business){?>
											 <?php if(isset($business_id)){ if($business_id==$business['id']) { echo   $business['name']; }  }?>><?php ?> 
											<?php } } ?>
										 
										 
									</div>
								</div>
								<?php } ?>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1"><strong>Class Name</strong></label>
										<?php if(isset($class_details)) { $service_name = (isset($service_name) && $service_name!='')?$service_name:$class_details[0]['service_name']; } else { $service_name = (isset($service_name) && $service_name!='')?$service_name:''; }?>
										 <?php if(isset($service_name)) { echo $service_name; }?> 
										 
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1"><strong>Description</strong></label>
										<?php if(isset($class_details)) { $description = (isset($description) && $description!='')?$description:$class_details[0]['description']; } else { $description = (isset($description) && $description!='')?$description:''; }?>
										 <?php if(isset($description)) { echo $description; }?> 
										 
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1"><strong>Class Capacity</strong></label>
										<?php if(isset($class_details)) { $class_capacity = (isset($class_capacity) && $class_capacity!='')?$class_capacity:$class_details[0]['class_capacity']; } else { $class_capacity = (isset($class_capacity) && $class_capacity!='')?$class_capacity:''; }?>
										 <?php if(isset($class_capacity)) { echo $class_capacity; }?> 
										 
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<!-- <div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Service Category</label>
										<select class="form-control" multiple="multiple" data-plugin="select2" name="service_category_list[]">
											<?php if($all_service_category){?>
											<?php foreach($all_service_category as $category){?>
											<option value="<?php echo $category['id'];?>" <?php if(isset($service_category_list)){ if($service_category_list==$category['id']) { echo "selected"; }  }?>><?php echo $category['name'];?></option>
											<?php } } ?>
										</select>
										<div class="admin_content_error"><?php echo form_error('service_category_list'); ?></div>
									</div> -->
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1"><strong>Class Category</strong></label>
										<?php if(isset($class_details)) { $class_category_id = (isset($class_category_id) && $class_category_id!='')?$class_category_id:$class_details[0]['service_category_id']; } else { $class_category_id = (isset($class_category_id) && $class_category_id!='')?$class_category_id:''; }?>
										 
											<?php if($all_class_category){?>
											<?php foreach($all_class_category as $category){?>
											 <?php if(isset($class_category_id)){ if($class_category_id==$category['id']) { echo $category['name']; }  }?>
											<?php } } ?>
										 
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1"><strong>Service Resource</strong></label>

											<?php if (isset($all_resources)){?>
											<?php foreach($all_resources as $resource){?>
											 <?php if(isset($service_resource_list)){ if($service_resource_list==$resource['id']) { echo $resource['resource_name'].','; }  }?> 
											<?php } } ?>
										 
										<!-- <div class="admin_content_error"><?php echo form_error('service_resource_list[]'); ?> 
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<!-- <label class="form-control-label" for="inputGrid1"></label> -->
										<?php if(isset($class_details)) { $is_online = (isset($is_online) && $is_online!='')?$is_online:$class_details[0]['is_online']; } else { $is_online = (isset($is_online) && $is_online!='')?$is_online:''; }?>
									  	 
											 
												<div class=" ">
													 
													<label for="is_online"><strong>Is Online</strong></label>
													<?php if($is_online == '1'){ echo "Yes";}else{ echo "N/A";}?>
												</div>
											 
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<!-- <label class="form-control-label" for="inputGrid1"></label> -->
										<?php if(isset($class_details)) { $is_gst_tax = (isset($is_gst_tax) && $is_gst_tax!='')?$is_gst_tax:$class_details[0]['is_gst_tax']; } else { $is_gst_tax = (isset($is_gst_tax) && $is_gst_tax!='')?$is_gst_tax:''; }?>
									  	 
												<div class=" ">
													 
													<label for="is_gst_tax"><strong>Is GST Tax</strong></label>
													<?php if($is_gst_tax == '1'){ echo "Yes";}else{ echo "N/A";}?>
												</div>
											 
										<div class="admin_content_error"><?php echo form_error('is_gst_tax'); ?></div>
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<?php if(isset($class_details)) { $is_extra_time = (isset($is_extra_time) && $is_extra_time!='')?$is_extra_time:$class_details[0]['is_extra_time']; } else { $is_extra_time = (isset($is_extra_time) && $is_extra_time!='')?$is_extra_time:''; }?>
										 
												<div class=" ">
													 
													<label><strong>Is Eextra Time</strong></label>
													<?php if($is_extra_time == '1'){ echo "Yes";}else{ echo "N/A";}?>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="form-group  row hidecheckbox" data-plugin="formMaterial" >
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1"><strong>Extra Time Before</strong></label>
										<?php if(isset($class_details)) { $extra_time_before = (isset($extra_time_before) && $extra_time_before!='')?$extra_time_before:$class_details[0]['extra_time_before']; } else { $extra_time_before = (isset($extra_time_before) && $extra_time_before!='')?$extra_time_before:''; }?>
										 
										 
										<?php 
										
										$str = $extra_time_before; $h = explode(":",$str);	$n_h = $h[0] * 60; $n_m = $h[1]; $n_time =$n_h+$n_m; 
										
										$i=5;
										for($i=5;$i<=720;$i++) { ?>
										 
											<?php 
												$h = floor($i / 60);
												$m = floor($i -   floor($i / 60) * 60);
												if($h == 0)
												{
													if($n_time == $i){  echo $hours = ($i - floor($i / 60) * 60)."min"; }
												}else if($m == 0) {
													if($n_time == $i){  echo $hours = floor($i / 60)."h "; }
												}else{
													if($n_time == $i){  echo $hours = floor($i / 60)."h ".($i -   floor($i / 60) * 60). "min"; }
												}
												
									            
											 ?>	
											 
										<?php $i=$i+4; } ?>
									 
									</div>
								</div>
								<div class="form-group  row hidecheckbox" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1"><strong>Extra Time After</strong></label>
										<?php if(isset($class_details)) { $extra_time_after = (isset($extra_time_after) && $extra_time_after!='')?$extra_time_after:$class_details[0]['extra_time_after']; } else { $extra_time_after = (isset($extra_time_after) && $extra_time_after!='')?$extra_time_after:''; }?>
										<!-- <input type="text" class="form-control" name="extra_time_after" id="extra_time_after" value="<?php if(isset($extra_time_after)) { echo $extra_time_after; } ?>"> -->
										 
										<?php 
										
										$str = $extra_time_after; $h = explode(":",$str);	$n_h = $h[0] * 60; $n_m = $h[1]; $n_time =$n_h+$n_m; 
										
										$i=5;
										for($i=5;$i<=720;$i++) { ?>
										 
											<?php 
												$h = floor($i / 60);
												$m = floor($i -   floor($i / 60) * 60);
												if($h == 0)
												{
													if($n_time == $i){  echo $hours = ($i - floor($i / 60) * 60)."min"; }
												}else if($m == 0) {
													if($n_time == $i){  echo $hours = floor($i / 60)."h "; }
												}else{
													if($n_time == $i){  echo $hours = floor($i / 60)."h ".($i -   floor($i / 60) * 60). "min"; }
												}
												
									            
											 ?>	
											 
										<?php $i=$i+4; } ?>
									 
									</div>
								</div>
								<!-- <div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
												<label class="form-control-label" for="inputGrid1">Note</label>
												<input type="text" class="form-control" name="note" id="note">
									</div>
								</div> -->
								 
							<!-- </form> -->
						</div>
				</div>
				<div class="col-md-6">
						<div class="panel-body container-fluid">
							
							<!-- <form autocomplete="off" method="post" action="<?php echo base_url('admin/service/add_service'); ?>"> -->
								<input type="hidden" name="service_timing" value="service_timing">
								<div class="field_wrapper" >
								
								<div class="addmore_div" >


									<!-- <div class="single_div" id=""> -->
									<?php $admin_session = $this->session->userdata("admin_logged_in"); ?>
									
									<?php if(isset($service_timing_details)) { 
			                		foreach($service_timing_details as $row) { ?>

			                			<div class="allredy">
				            			<div class="row mb-10" data-plugin="formMaterial">
										   	<div class="col-md-4">
											  	<label class="form-control-label" for="inputGrid1"><strong>Caption</strong></label>
											  	 
											  	 <?php echo $row['caption']; ?> 
											   
										   	</div>
										   	<div class="col-md-4">
											  	<label class="form-control-label" for="inputGrid1"><strong>Duration</strong></label>
											  	<?php $duration = (isset($duration) && $duration!='')?$duration:$row['duration'];?> 
											  	  
										<?php 
										
										$str = $duration; $h = explode(":",$str);	$n_h = $h[0] * 60; $n_m = $h[1]; $n_time =$n_h+$n_m; 
										
										$i=5;
										for($i=5;$i<=720;$i++) { ?>
										 
											<?php 
												$h = floor($i / 60);
												$m = floor($i -   floor($i / 60) * 60);
												if($h == 0)
												{
													if($n_time == $i){ echo $hours = ($i - floor($i / 60) * 60)."min"; }
												}else if($m == 0) {
													if($n_time == $i){ echo $hours = floor($i / 60)."h "; }
												}else{
													if($n_time == $i){ echo $hours = floor($i / 60)."h ".($i -   floor($i / 60) * 60). "min"; }
												}
												
									            
											 ?>	
											 
										<?php $i=$i+4; } ?>
									  
										   	</div>
										   	<div>
										   		
										   	</div>
									  	</div>
									  	

									  	<div class="row mb-10" data-plugin="formMaterial">
										  	
										   	<div class="col-md-4">
											  	<label class="form-control-label" for="inputGrid1"><strong>Retail Price</strong></label>
											  	 <?php echo $row['retail_price']; ?> 
											   
										   	</div>
										   	<div class="col-md-4">
											  	<label class="form-control-label" for="inputGrid1"><strong>Special Price</strong></label>
											  	  <?php echo $row['special_price']; ?> 
											  	 
										   	</div>
									  	</div>
									  </div>

			                		<?php  } }  ?>
									<!-- </div> -->
								</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									 
								</div>
							<!-- </form> -->
						</div>
					<!-- End Panel Floating Labels -->
				</div>
				
			</div>
			 
		</div>
	</div>
</div>
<!-- End Page -->

<?php $this->load->view('admin/common/footer'); ?>
 
	
	
	
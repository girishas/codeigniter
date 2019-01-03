<?php $this->load->view('admin/common/header'); ?>
<style>
	.top_line {border-top: 1px solid grey;
	padding-top: 12px;    padding-bottom: 18px;}
	.admin_content_error {width: 100% !important;}
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
						<h1 class="page-title"><?php if($this->uri->segment('4') == '') { echo "Add Class"; } else{ echo "Edit Class"; } ?></h1><hr>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel-body" style="padding: 10px 30px;">
						<h1 class="page-title">Service Timing</h1><hr>
					</div>
				</div>
			</div>
			
			<form autocomplete="off" method="post" action="<?php echo base_url('admin/service/add_class/'.$this->uri->segment('4'));?>">
			<div class="row">

				<div class="col-md-6">						
						<div class="panel-body container-fluid">
								
								<input type="hidden" name="action" value="save">

								<?php $admin_session = $this->session->userdata('admin_logged_in');
								if($admin_session['role'] == 'owner') { ?>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Business*</label>
										<?php if(isset($class_details)) { $business_id = (isset($business_id) && $business_id!='')?$business_id:$class_details[0]['business_id']; } else { $business_id = (isset($business_id) && $business_id!='')?$business_id:''; }?>
										<select class="form-control" name="business_id">
											<option value="">Select Business</option>
											<?php if($all_business){?>
											<?php foreach($all_business as $business){?>
											<option value="<?php echo $business['id'];?>" <?php if(isset($business_id)){ if($business_id==$business['id']) { echo "selected"; }  }?>><?php echo $business['name'];?></option>
											<?php } } ?>
										</select>
										<div class="admin_content_error"><?php echo form_error('business_id'); ?></div>
									</div>
								</div>
								<?php } ?>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Class Name*</label>
										<?php if(isset($class_details)) { $service_name = (isset($service_name) && $service_name!='')?$service_name:$class_details[0]['service_name']; } else { $service_name = (isset($service_name) && $service_name!='')?$service_name:''; }?>
										<input type="text" class="form-control" name="service_name" id="inputPlaceholder" value="<?php if(isset($service_name)) { echo $service_name; }?>">
										<div class="admin_content_error"><?php echo form_error('service_name'); ?></div>
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Description*</label>
										<?php if(isset($class_details)) { $description = (isset($description) && $description!='')?$description:$class_details[0]['description']; } else { $description = (isset($description) && $description!='')?$description:''; }?>
										<textarea class="form-control" name="description" id="textareaDefault" rows="3"><?php if(isset($description)) { echo $description; }?></textarea>
										<div class="admin_content_error"><?php echo form_error('description'); ?></div>
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Class Capacity*</label>
										<?php if(isset($class_details)) { $class_capacity = (isset($class_capacity) && $class_capacity!='')?$class_capacity:$class_details[0]['class_capacity']; } else { $class_capacity = (isset($class_capacity) && $class_capacity!='')?$class_capacity:''; }?>
										<input type="number" min="1" class="form-control" name="class_capacity" id="inputPlaceholder" value="<?php if(isset($class_capacity)) { echo $class_capacity; }?>">
										<div class="admin_content_error"><?php echo form_error('class_capacity'); ?></div>
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
										<label class="form-control-label" for="inputGrid1">Class Category*</label>
										<?php if(isset($class_details)) { $class_category_id = (isset($class_category_id) && $class_category_id!='')?$class_category_id:$class_details[0]['service_category_id']; } else { $class_category_id = (isset($class_category_id) && $class_category_id!='')?$class_category_id:''; }?>
										<select class="form-control" name="class_category_id">
											<option value="">Select Class Category</option>
											<?php if($all_class_category){?>
											<?php foreach($all_class_category as $category){?>
											<option value="<?php echo $category['id'];?>" <?php if(isset($class_category_id)){ if($class_category_id==$category['id']) { echo "selected"; }  }?>><?php echo $category['name'];?></option>
											<?php } } ?>
										</select>
										<div class="admin_content_error"><?php echo form_error('class_category_id'); ?></div>
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Service Resource</label>
										<select class="form-control" multiple="multiple" data-plugin="select2" name="service_resource_list[]">
											<?php if($all_resources){?>
											<?php foreach($all_resources as $resource){?>
											<option value="<?php echo $resource['id'];?>" <?php if(isset($service_resource_list)){ if($service_resource_list==$resource['id']) { echo "selected"; }  }?>><?php echo $resource['resource_name'];?></option>
											<?php } } ?>
										</select>
										<!-- <div class="admin_content_error"><?php echo form_error('service_resource_list[]'); ?></div> -->
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<!-- <label class="form-control-label" for="inputGrid1"></label> -->
										<?php if(isset($class_details)) { $is_online = (isset($is_online) && $is_online!='')?$is_online:$class_details[0]['is_online']; } else { $is_online = (isset($is_online) && $is_online!='')?$is_online:''; }?>
									  	<ul class="list-unstyled list-inline">
											<li class="list-inline-item">
												<div class="checkbox-custom">&nbsp;&nbsp;</div>
											</li>
											<li class="list-inline-item">
												<div class="checkbox-custom checkbox-info">
													<input type="checkbox" id="is_online" name="is_online" <?php if($is_online == '1'){ echo "checked";}?> />
													<label for="is_online">Is Online</label>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<!-- <label class="form-control-label" for="inputGrid1"></label> -->
										<?php if(isset($class_details)) { $is_gst_tax = (isset($is_gst_tax) && $is_gst_tax!='')?$is_gst_tax:$class_details[0]['is_gst_tax']; } else { $is_gst_tax = (isset($is_gst_tax) && $is_gst_tax!='')?$is_gst_tax:''; }?>
									  	<ul class="list-unstyled list-inline">
											<li class="list-inline-item">
												<div class="checkbox-custom">&nbsp;&nbsp;</div>
											</li>
											<li class="list-inline-item">
												<div class="checkbox-custom checkbox-info">
													<input type="checkbox" id="is_gst_tax" name="is_gst_tax" <?php if($is_gst_tax == '1'){ echo "checked";}?> />
													<label for="is_gst_tax">Is GST Tax*</label>
												</div>
											</li>
										</ul>
										<div class="admin_content_error"><?php echo form_error('is_gst_tax'); ?></div>
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<?php if(isset($class_details)) { $is_extra_time = (isset($is_extra_time) && $is_extra_time!='')?$is_extra_time:$class_details[0]['is_extra_time']; } else { $is_extra_time = (isset($is_extra_time) && $is_extra_time!='')?$is_extra_time:''; }?>
										<ul class="list-unstyled list-inline">
											<li class="list-inline-item">
												<div class="checkbox-custom">&nbsp;&nbsp;</div>
											</li>
											<li class="list-inline-item">
												<div class="checkbox-custom checkbox-info">
													<input type="checkbox" name="is_extra_time" id="is_extra_time" <?php if($is_extra_time == '1'){ echo "checked";}?> />
													<label>Is Eextra Time</label>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="form-group  row hidecheckbox" data-plugin="formMaterial" >
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Extra Time Before</label>
										<?php if(isset($class_details)) { $extra_time_before = (isset($extra_time_before) && $extra_time_before!='')?$extra_time_before:$class_details[0]['extra_time_before']; } else { $extra_time_before = (isset($extra_time_before) && $extra_time_before!='')?$extra_time_before:''; }?>
										<!-- <input type="text" class="form-control" name="extra_time_before" id="extra_time_before" value="<?php if(isset($extra_time_before)) { echo $extra_time_before; } ?>"> -->
										<select class="form-control" name="extra_time_before" id="extra_time_before">
										<option value="">Select Duration</option>
										<?php 
										
										$str = $extra_time_before; $h = explode(":",$str);	$n_h = $h[0] * 60; $n_m = $h[1]; $n_time =$n_h+$n_m; 
										
										$i=5;
										for($i=5;$i<=720;$i++) { ?>
										<option value="<?php echo $i; ?>" <?php if($n_time == $i){ echo "selected";} ?> >

											<?php 
												$h = floor($i / 60);
												$m = floor($i -   floor($i / 60) * 60);
												if($h == 0)
												{
													echo $hours = ($i - floor($i / 60) * 60)."min";
												}else if($m == 0) {
													echo $hours = floor($i / 60)."h ";
												}else{
													echo $hours = floor($i / 60)."h ".($i -   floor($i / 60) * 60). "min";
												}
												
									            
											 ?>	
											</option>
										<?php $i=$i+4; } ?>
									</select>
									</div>
								</div>
								<div class="form-group  row hidecheckbox" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Extra Time After</label>
										<?php if(isset($class_details)) { $extra_time_after = (isset($extra_time_after) && $extra_time_after!='')?$extra_time_after:$class_details[0]['extra_time_after']; } else { $extra_time_after = (isset($extra_time_after) && $extra_time_after!='')?$extra_time_after:''; }?>
										<!-- <input type="text" class="form-control" name="extra_time_after" id="extra_time_after" value="<?php if(isset($extra_time_after)) { echo $extra_time_after; } ?>"> -->
										<select class="form-control" name="extra_time_after" id="extra_time_after">
										<option value="">Select Duration</option>
										<?php 
										
										$str = $extra_time_after; $h = explode(":",$str);	$n_h = $h[0] * 60; $n_m = $h[1]; $n_time =$n_h+$n_m; 
										
										$i=5;
										for($i=5;$i<=720;$i++) { ?>
										<option value="<?php echo $i; ?>" <?php if($n_time == $i){ echo "selected";} ?> >

											<?php 
												$h = floor($i / 60);
												$m = floor($i -   floor($i / 60) * 60);
												if($h == 0)
												{
													echo $hours = ($i - floor($i / 60) * 60)."min";
												}else if($m == 0) {
													echo $hours = floor($i / 60)."h ";
												}else{
													echo $hours = floor($i / 60)."h ".($i -   floor($i / 60) * 60). "min";
												}
												
									            
											 ?>	
											</option>
										<?php $i=$i+4; } ?>
									</select>
									</div>
								</div>
								<!-- <div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
												<label class="form-control-label" for="inputGrid1">Note</label>
												<input type="text" class="form-control" name="note" id="note">
									</div>
								</div> -->
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-6">
										<button class="btn btn-primary" data-dismiss="modal" type="submit">Save</button>
									</div>
								</div>
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
											  	<label class="form-control-label" for="inputGrid1">Caption*</label>
											  	<!-- <?php $caption = (isset($caption) && $caption!='')?$caption:$row['caption'];?> -->
											  	<input type="text" class="form-control" name="caption[]" id="caption"  value="<?php echo $row['caption']; ?>" required="">
											  	<div class="admin_content_error"><?php echo form_error("caption[]"); ?></div>
										   	</div>
										   	<div class="col-md-4">
											  	<label class="form-control-label" for="inputGrid1">Duration*</label>
											  	<?php $duration = (isset($duration) && $duration!='')?$duration:$row['duration'];?> 
											  	<!-- <input type="text" class="form-control" name="duration[]" id="duration" value="<?php echo $row['duration']; ?>" required=""> -->
											  	<select class="form-control" name="duration[]" id="duration" required="">
										<option value="">Select Duration</option>
										<?php 
										
										$str = $duration; $h = explode(":",$str);	$n_h = $h[0] * 60; $n_m = $h[1]; $n_time =$n_h+$n_m; 
										
										$i=5;
										for($i=5;$i<=720;$i++) { ?>
										<option value="<?php echo $i; ?>" <?php if($n_time == $i){ echo "selected";} ?> >

											<?php 
												$h = floor($i / 60);
												$m = floor($i -   floor($i / 60) * 60);
												if($h == 0)
												{
													echo $hours = ($i - floor($i / 60) * 60)."min";
												}else if($m == 0) {
													echo $hours = floor($i / 60)."h ";
												}else{
													echo $hours = floor($i / 60)."h ".($i -   floor($i / 60) * 60). "min";
												}
												
									            
											 ?>	
											</option>
										<?php $i=$i+4; } ?>
									</select>

											  	<div class="admin_content_error"><?php echo form_error("duration[]"); ?></div>
										   	</div>
										   	<div>
										   		
										   	</div>
									  	</div>
									  	

									  	<div class="row mb-10" data-plugin="formMaterial">
										  	
										   	<div class="col-md-4">
											  	<label class="form-control-label" for="inputGrid1">Retail Price*</label>
											  	<!-- <?php $retail_price = (isset($retail_price) && $retail_price!='')?$retail_price:$row['retail_price'];?> -->
											  	<input type="text" class="form-control" name="retail_price[]" id="retail_price" placeholder="0.00" value="<?php echo $row['retail_price']; ?>" required="" >
											  	<div class="admin_content_error"><?php echo form_error("retail_price[]"); ?></div>
										   	</div>
										   	<div class="col-md-4">
											  	<label class="form-control-label" for="inputGrid1">Special Price</label>
											  	<!-- <?php $special_price = (isset($special_price) && $special_price!='')?$special_price:$row['special_price'];?> -->
											  	<input type="text" class="form-control" name="special_price[]" id="special_price" placeholder="0.00" value="<?php echo $row['special_price']; ?>" required="" >
											  	<div class="admin_content_error"><?php echo form_error("special_price[]"); ?></div>
										   	</div>
									  	</div>
									  </div>

			                		<?php  } } else { ?>
			                		<div class="row mb-10" data-plugin="formMaterial">
									   	<div class="col-md-4">
										  	<label class="form-control-label" for="inputGrid1">Caption*</label>
										  	<!-- <?php $caption = (isset($caption) && $caption!='')?$caption:$row['caption'];?> -->
										  	<input type="text" class="form-control" name="caption[]" id="caption"  value="" required="">
										  	<div class="admin_content_error"><?php echo form_error("caption[]"); ?></div>
									   	</div>
									   	<div class="col-md-4">
										  	<label class="form-control-label" for="inputGrid1">Duration*</label>
										  	<!-- <?php $duration = (isset($duration) && $duration!='')?$duration:$row['duration'];?> -->
										  	<!-- <input type="text" class="form-control" name="duration[]" id="duration" value="" required="" > -->
										  	<select class="form-control" name="duration[]" id="duration" required="">
												<option value="">Select Duration</option>
												<?php $i=5;
												for($i=5;$i<=720;$i++) { ?>
												<option value="<?php echo $i; ?>">

													<?php 
														$h = floor($i / 60);
														$m = floor($i -   floor($i / 60) * 60);
														if($h == 0)
														{
															echo $hours = ($i - floor($i / 60) * 60)."min";
														}else if($m == 0) {
															echo $hours = floor($i / 60)."h ";
														}else{
															echo $hours = floor($i / 60)."h ".($i -   floor($i / 60) * 60). "min";
														}
													 ?>	
													</option>
												<?php $i=$i+4; } ?>
											</select>
											  	<div class="admin_content_error"><?php echo form_error("duration[]"); ?></div>
									   	</div>
									   	<div>
									   		
									   	</div>
								  	</div>
								  	

								  	<div class="row mb-10" data-plugin="formMaterial">
									  	
									   	<div class="col-md-4">
										  	<label class="form-control-label" for="inputGrid1">Retail Price*</label>
										  	<!-- <?php $retail_price = (isset($retail_price) && $retail_price!='')?$retail_price:$row['retail_price'];?> -->
										  	<input type="text" class="form-control" name="retail_price[]" id="retail_price" placeholder="0.00" value="" required="">
										  	<div class="admin_content_error"><?php echo form_error("retail_price[]"); ?></div>
									   	</div>
									   	<div class="col-md-4">
										  	<label class="form-control-label" for="inputGrid1">Special Price</label>
										  	<!-- <?php $special_price = (isset($special_price) && $special_price!='')?$special_price:$row['special_price'];?> -->
										  	<input type="text" class="form-control" name="special_price[]" id="special_price" placeholder="0.00" value="" >
										  	<div class="admin_content_error"><?php echo form_error("special_price[]"); ?></div>
									   	</div>
								  	</div>
			                		<?php } ?>
									<!-- </div> -->
								</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-4">
										
									</div>
									<div class="col-md-4">
										
									</div>
									<div class="col-md-4">
										<!-- <button type="button" class="btn btn-floating btn-info btn-sm waves-effect waves-light waves-round add_more"><i class="icon md-plus" aria-hidden="true"></i></button> -->
									</div>
								</div>
							<!-- </form> -->
						</div>
					<!-- End Panel Floating Labels -->
				</div>
				
			</div>
			</form>
		</div>
	</div>
</div>
<!-- End Page -->

<?php $this->load->view('admin/common/footer'); ?>
	
<!-- if is extra time -->
<script type="text/javascript">
	$(document).ready(function(){

		var x=0;
		$('.hidecheckbox').hide();
		$('#is_extra_time').click(function(){
			if($('#is_extra_time').is(":checked"))
			{	//alert('chk');
				$('.hidecheckbox').show();
				$("#extra_time_before").attr("required", "true");
				$("#extra_time_after").attr("required", "true");
			}
			else
			{
				$('.hidecheckbox').hide();
				$("#extra_time_before").removeAttr("required");
				$("#extra_time_after").removeAttr("required");
			}
		});
		/*$('.hidecheckbox').hide();
		if($('#is_extra_time').is(":checked"))
		{
			$('.hidecheckbox').show();
			$("#extra_time_before").attr("required", "true");
			$("#extra_time_after").attr("required", "true");
		}
		else
		{
			$('.hidecheckbox').hide();
		}
		
		$('#is_extra_time').click(function(){
			if($('#is_extra_time').is(":checked"))
			{
				//alert('chk');
				$('.hidecheckbox').show();
			}
			else
			{
				$('.hidecheckbox').hide();
			}
		});*/
		
		
		/*------------------ create array and create string to append in select-----*/
		
				
		var sess = '<?php echo $admin_session["role"]; ?>';
		addButton = $('.add_more');
		//alert(sess);


		if(sess === 'owner')
		{ 

		 	//Add button selector
		 	var wrapper = $('.field_wrapper'); //Input field wrapper
			var fieldHTML = '<div class="addmore_div top_line" ><div class="row" data-plugin="formMaterial"><div class="col-md-4"><label class="form-control-label" for="inputGrid1">Caption*</label><input type="text" class="form-control" name="caption[]" id="caption" required=""  value=""><div class="admin_content_error"></div></div><div class="col-md-4"><label class="form-control-label" for="inputGrid1">Duration*</label><input type="text" class="form-control" name="duration[]" id="duration" required=""  value=""><div class="admin_content_error"></div></div><a href="javascript:void(0);" class="remove_button" title="Remove fields"><span class="glyphicon glyphicon-minus">Remove</span></a></div><div class="row" data-plugin="formMaterial"><div class="col-md-4"><label class="form-control-label" for="inputGrid1">Retail Price*</label><input type="text" class="form-control" name="retail_price[]" id="retail_price" placeholder="0.00" required="" value=""><div class="admin_content_error"></div></div><div class="col-md-4"><label class="form-control-label" for="inputGrid1">Special Price</label><input type="text" class="form-control" name="special_price[]" id="special_price" placeholder="0.00" value=""><div class="admin_content_error"></div></div></div></div>';
			
		}
		else
		{

			var wrapper = $('.field_wrapper'); //Input field wrapper
			var fieldHTML = '<div class="addmore_div top_line" ><div class="row" data-plugin="formMaterial"><div class="col-md-4"><label class="form-control-label" for="inputGrid1">Caption*</label><input type="text" class="form-control" name="caption[]" id="caption" required=""  value=""><div class="admin_content_error"></div></div><div class="col-md-4"><label class="form-control-label" for="inputGrid1">Duration*</label><input type="text" class="form-control" name="duration[]" id="duration" required=""  value=""><div class="admin_content_error"></div></div><a href="javascript:void(0);" class="remove_button" title="Remove fields"><span class="glyphicon glyphicon-minus">Remove</span></a></div><div class="row" data-plugin="formMaterial"><div class="col-md-4"><label class="form-control-label" for="inputGrid1">Retail Price*</label><input type="text" class="form-control" name="retail_price[]" required="" id="retail_price" placeholder="0.00" value=""><div class="admin_content_error"></div></div><div class="col-md-4"><label class="form-control-label" for="inputGrid1">Special Price</label><input type="text" class="form-control" name="special_price[]" id="special_price" placeholder="0.00" value=""><div class="admin_content_error"></div></div></div></div>';
		}
		
		$(addButton).click(function(){ //Once add button is clicked
				x++; //Increment field counter
				//alert('132');
				$(wrapper).append(fieldHTML); // Add field html
				
				// if(sess === 'owner'){
				// 	var arr = [];
				// 	var arr = '<?php if(isset($all_business)) { echo json_encode($all_business); } ?>';
				// 	arr = JSON.parse(arr);

				// 	$(".app_all_business option").remove();
				// 	$('.app_all_business').append('<option value="">Select Business</option>');
				// 	$.each(arr, function (index, value) {
				// 	  $('.app_all_business').append('<option value="'+value['id']+'">'+value['name']+'</option>');
				// 	});
				// }
				

				
		});
		$(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
			e.preventDefault();
			$(this).parents('.addmore_div').remove(); //Remove field html
			x--; //Decrement field counter
		});
		
		
		
		
	});
</script>
	
	
	
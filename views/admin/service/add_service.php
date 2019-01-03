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
				
				<li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab"  role="tab" >Services</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_service_category');?>" >Service Categories</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_service_group');?>" >Service Group</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_packages');?>" >Packages</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_class');?>" >Class</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link ""  href="<?php echo base_url('admin/service/all_class_category');?>" >Class Categories</a></li>
				
			</ul>
			<div class="page-header-actions">
				<a class="btn btn-info" href="<?php echo base_url('admin/service');?>">All Services</a>
			</div>
		</div>
			<div class="row">
				<div class="col-md-6">
					<div class="panel-body" style="padding: 10px 30px;">
						<h1 class="page-title">Add Service</h1><hr>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel-body" style="padding: 10px 30px;">
						<h1 class="page-title">Service Timing</h1><hr>
					</div>
				</div>
			</div>
			
			<form autocomplete="off" method="post" action="<?php echo base_url('admin/service/add_service'); ?>">
			<div class="row">

				<div class="col-md-6">						
						<div class="panel-body container-fluid">
								<input type="hidden" name="add_service" value="add_service">
								<?php $admin_session = $this->session->userdata('admin_logged_in');
								if($admin_session['role'] == 'owner') { ?>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Business*</label>
										<select class="form-control" id="business_id1" name="business_id1">
											<option value="">Select Business</option>
											<?php if($all_business){?>
											<?php foreach($all_business as $business){?>
											<option value="<?php echo $business['id'];?>" <?php if(isset($business_id1)){ if($business_id1==$business['id']) { echo "selected"; }  }?>><?php echo $business['name'];?></option>
											<?php } } ?>
										</select>
										<div class="admin_content_error"><?php echo form_error('business_id1'); ?></div>
									</div>
								</div>
								<?php } ?>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Service Name*</label>
										<input type="text" class="form-control" name="service_name" id="inputPlaceholder" value="<?php if(isset($service_name)) { echo $service_name; }?>">
										<div class="admin_content_error"><?php echo form_error('service_name'); ?></div>
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">SKU</label>
										<input type="text" class="form-control" name="sku" id="inputPlaceholder" value="<?php if(isset($sku)) { echo $sku; }?>">
										<div class="admin_content_error"><?php echo form_error('sku'); ?></div>
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Description*</label>
										<textarea class="form-control" name="description" id="textareaDefault" rows="3"><?php if(isset($description)) { echo $description; }?></textarea>
										<div class="admin_content_error"><?php echo form_error('description'); ?></div>
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
										<label class="form-control-label" for="inputGrid1">Service Category*</label>
										<select class="form-control" id="service_category_id" name="service_category_id">
											<option value="">Select Service Category</option>
											<!-- <?php if($all_service_category){?>
											<?php foreach($all_service_category as $category){?>
											<option value="<?php echo $category['id'];?>" <?php if(isset($service_category_id)){ if($service_category_id==$category['id']) { echo "selected"; }  }?>><?php echo $category['name'];?></option>
											<?php } } ?> -->
										</select>
										<div class="admin_content_error"><?php echo form_error('service_category_id'); ?></div>
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
										<!-- <div class="admin_content_error"><?php echo form_error('service_resource_list'); ?></div> -->
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<ul class="list-unstyled list-inline">
											<li class="list-inline-item">
												<div class="checkbox-custom">&nbsp;&nbsp;</div>
											</li>
											<li class="list-inline-item">
												<div class="checkbox-custom checkbox-info">
													<input type="checkbox" name="is_online"   />
													<label>Is Online</label>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<ul class="list-unstyled list-inline">
											<li class="list-inline-item">
												<div class="checkbox-custom">&nbsp;&nbsp;</div>
											</li>
											<li class="list-inline-item">
												<div class="checkbox-custom checkbox-info">
													<input type="checkbox" name="is_gst_tax"  />
													<label>Is GST Tax</label>
												</div>
											</li>
										</ul>
										<div class="admin_content_error"><?php echo form_error('is_gst_tax'); ?></div>
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<ul class="list-unstyled list-inline">
											<li class="list-inline-item">
												<div class="checkbox-custom">&nbsp;&nbsp;</div>
											</li>
											<li class="list-inline-item">
												<div class="checkbox-custom checkbox-info">
													<input type="checkbox" name="is_extra_time" id="is_extra_time" />
													<label>Is Extra Time</label>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<ul class="list-unstyled list-inline">
											<li class="list-inline-item">
												<div class="checkbox-custom">&nbsp;&nbsp;</div>
											</li>
											<li class="list-inline-item">
												<div class="checkbox-custom checkbox-info">
													<input type="checkbox" name="is_service_group" id="is_service_group" />
													<label>Is Service Group</label>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<!-- <div class="form-group  row hidecheckbox" data-plugin="formMaterial" >
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Extra Time Before</label>
										
										<select class="form-control" name="extra_time_before" id="extra_time_before">
												<option value="">Select Duration</option>
												<option value="0">0min</option>
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
									</div>
								</div> -->
								<!-- <input type="text" class="form-control duration" value="" name="extra_time_before" id="extra_time_before"> -->
								<div class="form-group  row hidecheckbox" data-plugin="formMaterial">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Extra Time After</label>
										<!-- <input type="text" class="form-control duration" name="extra_time_after" id="extra_time_after"> -->
										<select class="form-control" name="extra_time_after" id="extra_time_after">
												<option value="">Select Duration</option>
												<option value="0">0min</option>
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
									
									<div class="row mb-10" data-plugin="formMaterial">
										<div class="col-md-4">
											<label class="form-control-label" for="inputGrid1">Caption*</label>
											<input type="text" class="form-control" name="caption[]" id="caption"  value="" required="">
											<div class="admin_content_error"><?php echo form_error("caption[]"); ?></div>
										</div>
										<div class="col-md-4">
											<label class="form-control-label" for="inputGrid1">Duration*</label>
											<!-- <input type="text" class="form-control" name="duration[]" id="duration"  value="" required=""> -->
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
									</div>

									<div class="row mb-10" data-plugin="formMaterial">
										
										<div class="col-md-4">
											<label class="form-control-label" for="inputGrid1">Retail Price*</label>
											<input type="text" class="form-control" name="retail_price[]" id="retail_price" placeholder="0.00" value="" required="">
											<div class="admin_content_error"><?php echo form_error("retail_price[]"); ?></div>
										</div>
										<div class="col-md-4">
											<label class="form-control-label" for="inputGrid1">Special Price</label>
											<input type="text" class="form-control" name="special_price[]" id="special_price" placeholder="0.00" value="">
											<div class="admin_content_error"><?php echo form_error("special_price[]"); ?></div>
										</div>
									</div>
									<!-- </div> -->
								</div>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-4">
										<!-- <button class="btn btn-primary" data-dismiss="modal" type="submit">Save</button> -->
									</div>
									<div class="col-md-4">
										
									</div>
									<div class="col-md-4">
										<button type="button" class="btn btn-floating btn-info btn-sm waves-effect waves-light waves-round add_more"><i class="icon md-plus" aria-hidden="true"></i></button>
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
			$('.duration').timepicker({
				'timeFormat': 'H:i'
			});
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
			
			
			/*------------------ create array and create string to append in select-----*/
			
					
			var sess = '<?php echo $admin_session["role"]; ?>';
			addButton = $('.add_more');
			//alert(sess);


			if(sess === 'owner')
			{ 

			 	//Add button selector
			 	var wrapper = $('.field_wrapper'); //Input field wrapper
				var fieldHTML = '<div class="addmore_div top_line" ><div class="row" data-plugin="formMaterial"><div class="col-md-4"><label class="form-control-label" for="inputGrid1">Caption*</label><input type="text" class="form-control" name="caption[]" id="caption" required=""  value=""><div class="admin_content_error"></div></div><div class="col-md-4"><label class="form-control-label" for="inputGrid1">Duration*</label><select class="form-control" name="duration[]" id="duration" required=""><option value="">Select Duration</option><?php $i=5;for($i=5;$i<=720;$i++) { ?><option value="<?php echo $i; ?>"><?php $h = floor($i / 60);$m = floor($i -   floor($i / 60) * 60);if($h == 0){echo $hours = ($i -   floor($i / 60) * 60). "min";}else if($m == 0) {echo $hours = floor($i / 60)."h";}else{echo $hours = floor($i / 60)."h ".($i -   floor($i / 60) * 60). "min";}?>	</option><?php $i=$i+4; } ?></select><div class="admin_content_error"></div></div><a href="javascript:void(0);" class="remove_button" title="Remove fields"><span class="glyphicon glyphicon-minus">Remove</span></a></div><div class="row" data-plugin="formMaterial"><div class="col-md-4"><label class="form-control-label" for="inputGrid1">Retail Price*</label><input type="text" class="form-control" name="retail_price[]" id="retail_price" placeholder="0.00" required="" value=""><div class="admin_content_error"></div></div><div class="col-md-4"><label class="form-control-label" for="inputGrid1">Special Price</label><input type="text" class="form-control" name="special_price[]" id="special_price" placeholder="0.00" value=""><div class="admin_content_error"></div></div></div></div>';
				
			}
			else
			{

				var wrapper = $('.field_wrapper'); //Input field wrapper
				var fieldHTML = '<div class="addmore_div top_line" ><div class="row" data-plugin="formMaterial"><div class="col-md-4"><label class="form-control-label" for="inputGrid1">Caption*</label><input type="text" class="form-control" name="caption[]" id="caption" required=""  value=""><div class="admin_content_error"></div></div><div class="col-md-4"><label class="form-control-label" for="inputGrid1">Duration*</label><select class="form-control" name="duration[]" id="duration" required=""><option value="">Select Duration</option><?php $i=5;for($i=5;$i<=720;$i++) { ?><option value="<?php echo $i; ?>"><?php $h = floor($i / 60);$m = floor($i -   floor($i / 60) * 60);if($h == 0){echo $hours = ($i -   floor($i / 60) * 60). "min";}else if($m == 0) {echo $hours = floor($i / 60)."h";}else{echo $hours = floor($i / 60)."h ".($i -   floor($i / 60) * 60). "min";}?>	</option><?php $i=$i+4; } ?></select><div class="admin_content_error"></div></div><a href="javascript:void(0);" class="remove_button" title="Remove fields"><span class="glyphicon glyphicon-minus">Remove</span></a></div><div class="row" data-plugin="formMaterial"><div class="col-md-4"><label class="form-control-label" for="inputGrid1">Retail Price*</label><input type="text" class="form-control" name="retail_price[]" required="" id="retail_price" placeholder="0.00" value=""><div class="admin_content_error"></div></div><div class="col-md-4"><label class="form-control-label" for="inputGrid1">Special Price</label><input type="text" class="form-control" name="special_price[]" id="special_price" placeholder="0.00" value=""><div class="admin_content_error"></div></div></div></div>';
			}
			
			$(addButton).click(function(){ //Once add button is clicked
					
					x++; //Increment field counter
					//alert('132');
					$(wrapper).append(fieldHTML); // Add field html
					initTimepicker();
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

		function initTimepicker(){
			$('.duration').timepicker({
				'timeFormat': 'H:i'
			});
		}



	</script>
	
<script>
$(document).ready(function(){

  var sess = '<?php echo $admin_session['role']; ?>';
  
  if(sess === 'owner'){
    $("#business_id1").change(function(){
      var id = this.value;
      //alert(id);
      $("#service_category_id option").remove();
      //$("#location_id").append('<option value="">Select Location</option>'); 

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url("admin/Operations/getAllServiceCategoryNameById/"); ?>'+id,
        datatype: 'json',
        success: function(data)
        {
          var arr = [];
          arr = JSON.parse(data);
          //alert(data);
          if(data != 'false'){
            ///$("#service_category_id option").remove();
            $("#service_category_id").append('<option value="">Select Service Category</option>'); 
            $.each(arr, function (index, value) {            
              //alert(value['location_name']);
              $("#service_category_id").append('<option value='+value['id']+'>'+value['name']+'</option>');       
            });

          }else{
            
            $("#service_category_id").append('<option value="">Select Service Category</option>'); 
          }
        }

      });
      
    });
  } // end of if
  else{
    var id = '<?php echo $admin_session['business_id']; ?>';

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url("admin/Operations/getAllServiceCategoryNameById/"); ?>'+id,
        datatype: 'json',
        success: function(data)
        {
          var arr = [];
          arr = JSON.parse(data);
          //alert(data);
          if(data != 'false'){
            
            $.each(arr, function (index, value) {            
              //alert(value['location_name']);
              $("#service_category_id").append('<option value='+value['id']+'>'+value['name']+'</option>');       
            });

          }
        }

      });

  } // end of else


 
  
});  // end of document.ready
</script>
	
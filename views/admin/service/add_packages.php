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
	  	<div class="page-header">
	      	<ul class="nav nav-tabs" role="tablist">
	        	
	        	<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service');?>" >Services</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_service_category');?>" >Service Categories</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_service_group');?>" >Service Group</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab"  role="tab" >Packages</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link " href="<?php echo base_url('admin/service/all_class');?>" >Class</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link "  href="<?php echo base_url('admin/service/all_class_category');?>" >Class Categories</a></li>
				
	      	</ul>
	      	<div class="page-header-actions">
	        	<a class="btn btn-info" href="<?php echo base_url('admin/service/all_packages');?>">All Packages</a>
	      	</div>
	    </div>		
      	<div class="row">
      		<div class="col-md-12">
      			<div class="panel-body" style="padding:10px 30px;">
      			<h1 class="page-title"><?php if($this->uri->segment('4') == '') { echo "Add Package"; } else{ echo "Edit Package"; } ?></h1><hr>
      		</div>
      		</div>
      	</div>

        <div class="row">

          <div class="col-md-12">
              <div class="panel-body container-fluid">
                <form autocomplete="off" method="post" action="<?php echo base_url('admin/service/add_package/'.$this->uri->segment('4'));?>" enctype="multipart/form-data">
					<input type="hidden" name="action" value="save">
                	<?php $admin_session = $this->session->userdata('admin_logged_in');
            		if($admin_session['role'] == 'owner') { ?>

            		
            		
        			<div class="form-group  row" data-plugin="formMaterial">
					  <div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1">Business*</label>
							<?php if(isset($package_details)) { $business_id = (isset($business_id) && $business_id!='')?$business_id:$package_details[0]['business_id']; } else { $business_id = (isset($business_id) && $business_id!='')?$business_id:''; }?>
					  		<select class="form-control" name="business_id">
		                      	<option value="">Select Business</option>
		                      	<?php if($all_business){?>
		                       	<?php foreach($all_business as $business){?>
		                       	<option value="<?php echo $business['id'];?>" <?php if(isset($business_id)){ if($business_id==$business['id']) { echo "selected"; }  }?>><?php echo $business['name'];?></option>
		                       	<?php } } ?>
		                    </select>
		                    <div class="admin_content_error"><?php echo form_error('business_id'); ?></div>
					   </div>
					   <div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1">Package Name*</label>
							<?php if(isset($package_details)) { $package_name = (isset($package_name) && $package_name!='')?$package_name:$package_details[0]['package_name']; } else { $package_name = (isset($package_name) && $package_name!='')?$package_name:''; }?>
						  	<input type="text" class="form-control" name="package_name" id="package_name" value="<?php if(isset($package_name)) { echo $package_name; }?>" >
						  	<div class="admin_content_error"><?php echo form_error('package_name'); ?></div>
					   </div>
				  	</div>

				  	<?php } else { ?>
					
					<div class="form-group  row" data-plugin="formMaterial">
						<div class="col-md-6">
							<label class="form-control-label" for="inputGrid1">Package Name*</label>
							<?php if(isset($package_details)) { $package_name = (isset($package_name) && $package_name!='')?$package_name:$package_details[0]['package_name']; } else { $package_name = (isset($package_name) && $package_name!='')?$package_name:''; }?>
						  	<input type="text" class="form-control" name="package_name" id="package_name" value="<?php if(isset($package_name)) { echo $package_name; }?>" >
						  	<div class="admin_content_error"><?php echo form_error('package_name'); ?></div>
						</div>
					   <div class="col-md-6">
							<label class="form-control-label" for="inputGrid1">SKU</label>
							<?php if(isset($package_details)) { $sku = (isset($sku) && $sku!='')?$sku:$package_details[0]['sku']; } else { $sku = (isset($sku) && $sku!='')?$sku:''; }?>
						  	<input type="text" class="form-control" name="sku" id="sku" value="<?php if(isset($sku)) { echo $sku; }?>" >
						  	<div class="admin_content_error"><?php echo form_error('sku'); ?></div>
					   </div>
				  	</div>	
					
					<?php } ?>
					
<!-- 
                  	<div class="form-group  row" data-plugin="formMaterial">
				  	 <div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1">Package Visit Limit*</label>
							<?php if(isset($package_details)) { $package_visit_limit = (isset($package_visit_limit) && $package_visit_limit!='')?$package_visit_limit:$package_details[0]['package_visit_limit']; } else { $package_visit_limit = (isset($package_visit_limit) && $package_visit_limit!='')?$package_visit_limit:''; }?>
						  	<input type="number" min="1" class="form-control" name="package_visit_limit" id="package_visit_limit" value="<?php if(isset($package_visit_limit)) { echo $package_visit_limit; }?>" >
						  	<div class="admin_content_error"><?php echo form_error('package_visit_limit'); ?></div>
					   	</div> 
						<div class="col-md-6">
						  	
					   	</div>
				  	</div> -->
					
					<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-12">
							<label class="form-control-label" for="inputGrid1">Description*</label>
							<?php if(isset($package_details)) { $description = (isset($description) && $description!='')?$description:$package_details[0]['description']; } else { $description = (isset($description) && $description!='')?$description:''; }?>
						  	<textarea class="form-control" name="description" id="description" rows="3"><?php if(isset($description)) { echo $description; }?></textarea>
							<div class="admin_content_error"><?php echo form_error('description'); ?></div>
					   	</div>
				  	</div>
					
					<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1">Cost Price*</label>
							<?php if(isset($package_details)) { $cost_price = (isset($cost_price) && $cost_price!='')?$cost_price:$package_details[0]['cost_price']; } else { $cost_price = (isset($cost_price) && $cost_price!='')?$cost_price:''; }?>
						  	<input type="text" class="form-control" name="cost_price" id="cost_price" value="<?php if(isset($cost_price)) { echo $cost_price; }?>" >
						  	<div class="admin_content_error"><?php echo form_error('cost_price'); ?></div>
					   	</div>
						<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1">Discounted Price*</label>
							<?php if(isset($package_details)) { $discounted_price = (isset($discounted_price) && $discounted_price!='')?$discounted_price:$package_details[0]['discounted_price']; } else { $discounted_price = (isset($discounted_price) && $discounted_price!='')?$discounted_price:''; }?>
						  	<input type="text" class="form-control" name="discounted_price" id="discounted_price" value="<?php if(isset($discounted_price)) { echo $discounted_price; }?>" >
						  	<div class="admin_content_error"><?php echo form_error('discounted_price'); ?></div>
					   	</div>
				  	</div>
					
					<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1"></label>
							<?php if(isset($package_details)) { $is_online = (isset($is_online) && $is_online!='')?$is_online:$package_details[0]['is_online']; } else { $is_online = (isset($is_online) && $is_online!='')?$is_online:''; }?>
						  	<ul class="list-unstyled list-inline">
								<li class="list-inline-item">
									<div class="checkbox-custom">&nbsp;&nbsp;</div>
								</li>
								<li class="list-inline-item">
									<div class="checkbox-custom checkbox-info">
										<input type="checkbox" id="is_online" name="is_online" <?php if($is_online == 1){ echo "checked";}?> />
										<label for="is_online">Is Online</label>
									</div>
								</li>
							</ul>
					   	</div>
						<div class="col-md-6">
							<label class="form-control-label" for="inputGrid1"></label>
							<?php if(isset($package_details)) { $is_gst_tax = (isset($is_gst_tax) && $is_gst_tax!='')?$is_gst_tax:$package_details[0]['is_gst_tax']; } else { $is_gst_tax = (isset($is_gst_tax) && $is_gst_tax!='')?$is_gst_tax:''; }?>
						  	<ul class="list-unstyled list-inline">
								<li class="list-inline-item">
									<div class="checkbox-custom">&nbsp;&nbsp;</div>
								</li>
								<li class="list-inline-item">
									<div class="checkbox-custom checkbox-info">
										<input type="checkbox" id="is_gst_tax" name="is_gst_tax" <?php if($is_gst_tax == 1){ echo "checked";}?> />
										<label for="is_gst_tax">Is GST Tax</label>
									</div>
								</li>
							</ul>
					   	</div>
				  	</div>
					
					<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid2">Redemption Start Date</label>
							<?php if(isset($package_details)) { $start_date = (isset($start_date) && $start_date!='')?$start_date:$package_details[0]['start_date']; } else { $start_date = (isset($start_date) && $start_date!='')?$start_date:''; }?>
							<input type="text" class="form-control" data-date-today-highlight="true" data-plugin="datepicker" id="start_date" name="start_date" value="<?php if(isset($start_date)) { echo $start_date; }?>" />
							<!-- <div class="admin_content_error"><?php echo form_error('start_date'); ?></div> -->
					   	</div>
						<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid2">Redemption End Date</label>
							<?php if(isset($package_details)) { $expire_date = (isset($expire_date) && $expire_date!='')?$expire_date:$package_details[0]['expire_date']; } else { $expire_date = (isset($expire_date) && $expire_date!='')?$expire_date:''; }?>
							<input type="text" class="form-control" data-date-today-highlight="true" data-plugin="datepicker" id="expire_date" name="expire_date" value="<?php if(isset($expire_date)) { echo $expire_date; }?>" />
							<!-- <div class="admin_content_error"><?php echo form_error('expire_date'); ?></div> -->
					   	</div>
				  	</div>
					
					<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1">Status</label>
						  	<?php if(isset($package_details)) { $status = (isset($status) && $status!='')?$status:$package_details[0]['status']; } else { $status = (isset($status) && $status!='')?$status:''; }?>
						  	<select class="form-control" name="status">
		                      	<option value="">Select Status</option>
		                      	<option value="1" <?php if(isset($status)){ if($status == '1') { echo "selected"; }} ?> >Active</option>
		                      	<option value="0" <?php if(isset($status)){ if($status == '0') { echo "selected"; }} ?> >Inactive</option>
		                    </select>
					   	</div>
						<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid2">Photo</label>
							<div class="form-group">
								<div class="input-group input-group-file" data-plugin="inputGroupFile">
								  <input type="text" class="form-control" readonly>
								  <span class="input-group-append">
									<span class="btn btn-success btn-file">
									  <i class="icon md-upload" aria-hidden="true"></i>
									  <input type="file" name="photo" id="photo">
									</span>
								  </span>
								</div>
							</div>
					   	</div>
				  	</div>
					
					<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1">Package Item</label>
						  	<div class="">
								<select class="form-control" data-plugin="select2" data-placeholder="Select Package Item" id="pack_item">
									<option value=""></option>
									<?php if($all_service_timing) {
										
										$disabled=null;
										foreach($all_service_timing as $key=>$value) { 
										
										$i = 0;
										$count = count((array)$service_timing_details);
										if(isset($service_timing_details))
										{
											for($i=0;$i<$count;$i++) {

												if($service_timing_details[$i]['service_timing_id']==$value['id'])
												{
													$disabled="disabled";
													break;
												}else{
													$disabled="";
												} 
											}											
										}
										
										?>
										<option <?=$disabled; ?> value="<?php echo $value['id'] ?>"><?php echo $value['sn']." ".$value['caption']." ".$value['special_price'];?></option>
									<?php } } //} } ?>
								</select>
							</div>
							<!-- <div class="admin_content_error"><?php echo form_error('expiry_date'); ?></div> -->
					   	</div>
						<div class="col-md-6">
						  	
					   	</div>
				  	</div>
					
					<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-12">
							<div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
								<!--<div class="col-md-3 mb-5">Service Name</div>
								<div class="col-md-3 mb-5">Caption</div>
								<div class="col-md-3 mb-5">Price</div>
								<div class="col-md-3 mb-5">Action</div>-->
								<table class="table table-hover dataTable table-striped w-full" >
									<thead>
										<th>Caption</th>
										<th>Service Name</th>
										<th>Price</th>
										<th>Limit</th>
										<th>Action</th>
									</thead>
									<tbody class="field_wrapper ">
										<?php if(isset($service_timing_details)) { foreach ($service_timing_details as $key=>$row) { ?>
										
										<tr class="addmore_div" id="<?php echo $row['service_timing_id'] ?>" >
											<td class=" cap"><?php echo getCaptionName($row['service_timing_id']); ?><input type="hidden" name="service_timing_id[]" value="<?php echo $row['service_timing_id'] ?>"></td>
											<td class=" s_name"><?php echo getServiceName($row['service_id']); ?><input type="hidden" name="service_id[]" value="<?php echo $row['service_id'] ?>"></td>
											<td class=" rp"><?php echo $row['amount'] ?><input type="hidden" name="amount[]" value="<?php echo $row['amount'] ?>"></td>
											<td width="100" class=" vl"><input type="number" name="visit_limit[]" class="form-control" min="1" value="<?php echo $row['visit_limit'] ?>"></td>
											<td class=""><a href="javascript:void(0);" class="remove_button1" title="Remove fields" id=<?php echo $row['service_timing_id'] ?>><span class="glyphicon glyphicon-minus">Remove</span></a></td>
										</tr>
										
										<?php } } else { ?>
										
										<tr class="addmore_div">
											
										</tr>	
										
										<?php } ?>
									</tbody>
								</table>
								
								

							</div>
						</div>
					</div>
					
				   <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <button class="btn btn-primary" data-dismiss="modal" type="submit">Save</button>
                    </div>                    
                  </div>
				  
                </form>
            <!-- End Panel Static Labels -->
          </div>

          		  
        </div>
      </div>
    </div>
</div>
</div>
        <!-- End Page -->

<?php $this->load->view('admin/common/footer'); ?>

<script>
$(document).ready(function(){

	$("#pack_item").change(function(){

		var id = $(this).val();

		// get record
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url("admin/Operations/getSingleServicetiming/"); ?>'+id,
			datatype: 'json',
			success: function(data)
			{
				var arr = [];
				arr = JSON.parse(data);
				//alert(data);
				$.each(arr, function (index, value) {

					//alert(value['service_id']);
					var service_name = value['sn'];
					
					$(".field_wrapper").append('<tr class="addmore_div" ><td class=" cap">'+value["caption"]+'<input type="hidden" name="service_timing_id[]" value="'+value["id"]+'"></td><td class=" s_name">'+service_name+'<input type="hidden" name="service_id[]" value="'+value["service_id"]+'"></td><td class=" rp">'+value["special_price"]+'<input type="hidden" name="amount[]" value="'+value["special_price"]+'"></td><td class=" vl"><input type="number" class="form-control" style="width:100px;" min="1" name="visit_limit[]"></td><td class=""><a href="javascript:void(0);" class="remove_button" title="Remove fields" id='+value["id"]+'><span class="glyphicon glyphicon-minus">Remove</span></a></td></tr>');
					
					//$("#pack_item option[value="+value['id']+"]").remove();
					$("#pack_item option[value="+value['id']+"]").prop('disabled', true);
					$('select').select2();
				});

			}

		});

		//$("#pack_item option[value="+id+"]").prop('disabled', true);

		 $(".field_wrapper").on('click', '.remove_button', function(e){ 
		 	e.preventDefault();
		 	$(this).parents('.addmore_div').remove(); 
		 	//alert(this.id);
		 	//var s = $(this).parents('.addmore_div');
		 	//var sname = $(this).parent().parent().children('.s_name').html();
		 	//var cap = $(this).parent().parent().children('.cap').html();
		 	//var price = $(this).parent().parent().children('.rp').html();
		 	//$("#pack_item).append('<option value="">"+sname+" "+cap+" "+price+"</option>');
			
		 	$("#pack_item option[value="+this.id+"]").prop('disabled', false);
		 	$('select').select2();
		 	return false;
	 	});
		
		
		
	});
	
	

	$(".field_wrapper").on('click', '.remove_button1', function(e){ 
		e.preventDefault();

		//alert('11111 - '+this.id);
		$(this).parents('.addmore_div').remove(); 
		//$("#pack_item option[value="+this.id+"]").prop('disabled', false);
		$("#pack_item option[value="+this.id+"]").removeAttr('disabled');
		//$('#pack_item').prop('disabled', !$('#one').prop('disabled'));
		$('select').select2();
		return false;
	});
	
	
});	

</script>


<script>
/*$(document).ready(function(){
	$("#pack_item").change(function(){
		//alert($(this).val());
		var id = $(this).val();
		//alert(id);
		// get record
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url("admin/Operations/getSingleServicetiming/"); ?>'+id,
			datatype: 'json',
			success: function(data)
			{
				var arr = [];
				arr = JSON.parse(data);
				//alert(data);
				$.each(arr, function (index, value) {

					//alert(value['service_id']);
					var service_name = value['sn'];
					
					$(".field_wrapper").append('<div class="addmore_div row" ><div class="col-md-3 mb-5 s_name">'+service_name+'<input type="hidden" name="service_id[]" value="'+value["service_id"]+'"></div><div class="col-md-3 mb-5 cap">'+value["caption"]+'<input type="hidden" name="service_timing_id[]" value="'+value["id"]+'"></div><div class="col-md-3 mb-5 rp">'+value["special_price"]+'<input type="hidden" name="amount[]" value="'+value["special_price"]+'"></div><div class="col-md-3 mb-5"><a href="javascript:void(0);" class="remove_button" title="Remove fields" id='+value["id"]+'><span class="glyphicon glyphicon-minus">Remove</span></a></div></div>');
					
					//$("#pack_item option[value="+value['id']+"]").remove();
					$("#pack_item option[value="+value['id']+"]").prop('disabled', true);
					
				});

			}

		});

		$(".field_wrapper").on('click', '.remove_button', function(e){ 
			e.preventDefault();
			$(this).parents('.addmore_div').remove(); 
			//alert(this.id)
			//var s = $(this).parents('.addmore_div');
			//var sname = $(this).parent().parent().children('.s_name').html();
			//var cap = $(this).parent().parent().children('.cap').html();
			//var price = $(this).parent().parent().children('.rp').html();
			//$("#pack_item).append('<option value="">"+sname+" "+cap+" "+price+"</option>');
			$("#pack_item option[value="+this.id+"]").prop('disabled', false);
			$('#pack_item option').prop('selected', function() {
				return this.defaultSelected;
			});
			return false;
		});
		
		
		
	});
	
});	
*/
</script>
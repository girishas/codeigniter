<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
<?php $this->load->view('admin/common/left_menubar'); ?>  
 <!-- Page -->
    <div class="page">
      
      <!-- <div class="page-header">
        <h1 class="page-title">Add New Service</h1>        
        <div class="page-header-actions"><a href="<?php echo base_url('admin/service');?>"><button type="button" class="btn btn-block btn-primary">All Services</button></a></div>
      </div> -->

	  	<div class="page-header">
	      	<ul class="nav nav-tabs" role="tablist">
	        	<li class="nav-item" role="presentation"><a class="nav-link " href="<?php echo base_url('admin/service');?>" >Services</a></li>
	        	<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/add_service_category');?>" >Categories</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab"  role="tab" href="<?php echo base_url('admin/service/all_packages');?>" >Packages</a></li>
	      	</ul>
	      	<div class="page-header-actions">
	        	<a class="btn btn-info" href="<?php echo base_url('admin/service/all_packages');?>">All Packages</a>
	      	</div>
	    </div>		

      <div class="page-content container-fluid">
      	
      	<div class="row">
      		<div class="col-md-6">
      			<h1 class="page-title">Edit Package</h1>
      		</div>
      	</div>

        <div class="row">

          <div class="col-md-12">
            <!-- Panel Static Labels -->
            <div class="panel">
              
              <div class="panel-body container-fluid">
                <form autocomplete="off" method="post" action="<?php echo base_url('admin/service/add_package'.$this->uri->segment('4'))?>" enctype="multipart/form-data">

                	<?php $admin_session = $this->session->userdata('admin_logged_in');
            		if($admin_session['role'] == 'owner') { ?>

            		<input type="hidden" name="action" value="save">
            		
        			<div class="form-group  row" data-plugin="formMaterial">
					  <div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1">Business*</label>
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
						  	<input type="text" class="form-control" name="package_name" id="package_name" value="<?php if(isset($package_name)) { echo $package_name; }?>" >
						  	<div class="admin_content_error"><?php echo form_error('package_name'); ?></div>
					   </div>
				  	</div>

				  	<?php } else { ?>
					
					<div class="form-group  row" data-plugin="formMaterial">
						<div class="col-md-6">
							<label class="form-control-label" for="inputGrid1">Package Name*</label>
						  	<input type="text" class="form-control" name="package_name" id="package_name" value="<?php if(isset($package_name)) { echo $package_name; }?>" >
						  	<div class="admin_content_error"><?php echo form_error('package_name'); ?></div>
						</div>
					   <div class="col-md-6">
							
					   </div>
				  	</div>	
					
					<?php } ?>
					

                  	<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1">Package Visit Limit*</label>
						  	<input type="number" min="1" class="form-control" name="package_visit_limit" id="package_visit_limit" value="<?php if(isset($package_visit_limit)) { echo $package_visit_limit; }?>" >
						  	<div class="admin_content_error"><?php echo form_error('package_visit_limit'); ?></div>
					   	</div>
						<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1">SKU</label>
						  	<input type="text" class="form-control" name="sku" id="sku" value="<?php if(isset($sku)) { echo $sku; }?>" >
						  	<div class="admin_content_error"><?php echo form_error('sku'); ?></div>
					   	</div>
				  	</div>
					
					<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-12">
							<label class="form-control-label" for="inputGrid1">Description*</label>
						  	<textarea class="form-control" name="description" id="description" rows="3"><?php if(isset($description)) { echo $description; }?></textarea>
							<div class="admin_content_error"><?php echo form_error('description'); ?></div>
					   	</div>
				  	</div>
					
					<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1">Cost Price*</label>
						  	<input type="text" class="form-control" name="cost_price" id="cost_price" value="<?php if(isset($cost_price)) { echo $cost_price; }?>" >
						  	<div class="admin_content_error"><?php echo form_error('cost_price'); ?></div>
					   	</div>
						<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1">Discounted Price</label>
						  	<input type="text" class="form-control" name="discounted_price" id="discounted_price" value="<?php if(isset($discounted_price)) { echo $discounted_price; }?>" >
						  	<!-- <div class="admin_content_error"><?php echo form_error('discounted_price'); ?></div> -->
					   	</div>
				  	</div>
					
					<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1"></label>
						  	<ul class="list-unstyled list-inline">
								<li class="list-inline-item">
									<div class="checkbox-custom">&nbsp;&nbsp;</div>
								</li>
								<li class="list-inline-item">
									<div class="checkbox-custom checkbox-info">
										<input type="checkbox" name="is_online"  />
										<label>Is Online</label>
									</div>
								</li>
							</ul>
					   	</div>
						<div class="col-md-6">
							<label class="form-control-label" for="inputGrid1"></label>
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
					   	</div>
				  	</div>
					
					<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid2">Redimption Start Date</label>
							<input type="text" class="form-control" data-date-today-highlight="true" data-plugin="datepicker" id="start_date" name="start_date" value="<?php if(isset($start_date)) { echo $start_date; }?>" />
							<!-- <div class="admin_content_error"><?php echo form_error('start_date'); ?></div> -->
					   	</div>
						<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid2">Redimption End Date</label>
							<input type="text" class="form-control" data-date-today-highlight="true" data-plugin="datepicker" id="expire_date" name="expire_date" value="<?php if(isset($expire_date)) { echo $expire_date; }?>" />
							<!-- <div class="admin_content_error"><?php echo form_error('expire_date'); ?></div> -->
					   	</div>
				  	</div>
					
					<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1">Package Item</label>
						  	<div class="">
								<select class="form-control" data-plugin="select2" data-placeholder="Select Package Item" id="pack_item">
									<option value=""></option>
									<?php if($all_service_timing) {
									foreach($all_service_timing as $key=>$value) { ?>
										<option value="<?php echo $value['id'] ?>"><?php echo $value['sn']." ".$value['caption']." ".$value['retail_price'];?></option>
									<?php } } ?>
								</select>
							</div>
							<div class="admin_content_error"><?php echo form_error('expiry_date'); ?></div>
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
				  		<div class="col-md-12 m-50">
						<div class="field_wrapper">
							<div class="addmore_div row">
								<div class="col-md-3 mb-5">Service Name</div>
								<div class="col-md-3 mb-5">Caption</div>
								<div class="col-md-3 mb-5">Price</div>
								<div class="col-md-3 mb-5">Action</div>
							</div>
						</div>
						</div>
					</div>
					
				   <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <button class="btn btn-primary" data-dismiss="modal" type="submit">Save</button>
                    </div>                    
                  </div>
				  
                </form>
              </div>
            </div>
            <!-- End Panel Static Labels -->
          </div>

          <input type="hidden" name="service_id[]" value="">
		  <input type="hidden" name="service_timing_id[]" value="">
		  <input type="hidden" name="amount[]" value="">
		  
        </div>
      </div>
    </div>
    <!-- End Page -->

<?php $this->load->view('admin/common/footer'); ?>

<script>
$(document).ready(function(){
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
					
					$(".field_wrapper").append('<div class="addmore_div row" ><div class="col-md-3 mb-5 s_name">'+service_name+'<input type="hidden" name="service_id[]" value="'+value["service_id"]+'"></div><div class="col-md-3 mb-5 cap">'+value["caption"]+'<input type="hidden" name="service_timing_id[]" value="'+value["id"]+'"></div><div class="col-md-3 mb-5 rp">'+value["retail_price"]+'<input type="hidden" name="amount[]" value="'+value["retail_price"]+'"></div><div class="col-md-3 mb-5"><a href="javascript:void(0);" class="remove_button" title="Remove fields" id='+value["id"]+'><span class="glyphicon glyphicon-minus">Remove</span></a></div></div>');
					
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
$(document).ready(function() {
    
});
</script>
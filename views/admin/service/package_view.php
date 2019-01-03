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
      			<h1 class="page-title"><?php if($this->uri->segment('4') == '') { echo "Add Package"; } else{ echo "Package Info"; } ?></h1><hr>
      		</div>
      		</div>
      	</div>

        <div class="row">

          <div class="col-md-12">
              <div class="panel-body container-fluid">
                
					<input type="hidden" name="action" value="save">
                	<?php $admin_session = $this->session->userdata('admin_logged_in');
            		if($admin_session['role'] == 'owner') { ?>

            		
            		
        			<div class="form-group  row" data-plugin="formMaterial">
					  <div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1"><strong>Business</strong></label>
							<?php if(isset($package_details)) { $business_id = (isset($business_id) && $business_id!='')?$business_id:$package_details[0]['business_id']; } else { $business_id = (isset($business_id) && $business_id!='')?$business_id:''; }?>
					  		 
		                      	<?php if($all_business){?>
		                       	<?php foreach($all_business as $business){?>
		                       	 <?php if(isset($business_id)){ if($business_id==$business['id']) { echo $business['name']; }  }?> 
		                       	<?php } } ?>
		                    
		                     
					   </div>
					   <div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1"><strong>Package Name</strong></label>
							<?php if(isset($package_details)) { $package_name = (isset($package_name) && $package_name!='')?$package_name:$package_details[0]['package_name']; } else { $package_name = (isset($package_name) && $package_name!='')?$package_name:''; }?>
						  	 <?php if(isset($package_name)) { echo $package_name; }?>
						  	 
					   </div>
				  	</div>

				  	<?php } else { ?>
					
					<div class="form-group  row" data-plugin="formMaterial">
						<div class="col-md-6">
							<label class="form-control-label" for="inputGrid1"><strong>Package Name</strong></label>
							<?php if(isset($package_details)) { $package_name = (isset($package_name) && $package_name!='')?$package_name:$package_details[0]['package_name']; } else { $package_name = (isset($package_name) && $package_name!='')?$package_name:''; }?>
						  	 <?php if(isset($package_name)) { echo $package_name; }?> 
						  	 
						</div>
					   <div class="col-md-6">
							<label class="form-control-label" for="inputGrid1"><strong>SKU</strong></label>
							<?php if(isset($package_details)) { $sku = (isset($sku) && $sku!='')?$sku:$package_details[0]['sku']; } else { $sku = (isset($sku) && $sku!='')?$sku:''; }?>
						  	 <?php if(isset($sku)) { echo $sku; }?>
						  	 
					   </div>
				  	</div>	
					
					<?php } ?>
					
<!-- 
                  	<div class="form-group  row" data-plugin="formMaterial">
				  	 <div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1">Package Visit Limit</label>
							<?php if(isset($package_details)) { $package_visit_limit = (isset($package_visit_limit) && $package_visit_limit!='')?$package_visit_limit:$package_details[0]['package_visit_limit']; } else { $package_visit_limit = (isset($package_visit_limit) && $package_visit_limit!='')?$package_visit_limit:''; }?>
						  	<input type="number" min="1" class="form-control" name="package_visit_limit" id="package_visit_limit" value="<?php if(isset($package_visit_limit)) { echo $package_visit_limit; }?>" >
						  	 
					   	</div> 
						<div class="col-md-6">
						  	
					   	</div>
				  	</div> -->
					
					<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-12">
							<label class="form-control-label" for="inputGrid1"><strong>Description</strong></label>
							<?php if(isset($package_details)) { $description = (isset($description) && $description!='')?$description:$package_details[0]['description']; } else { $description = (isset($description) && $description!='')?$description:''; }?>
						  	<?php if(isset($description)) { echo $description; }?> 
							 
					   	</div>
				  	</div>
					
					<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1"><strong>Cost Price</strong></label>
							<?php if(isset($package_details)) { $cost_price = (isset($cost_price) && $cost_price!='')?$cost_price:$package_details[0]['cost_price']; } else { $cost_price = (isset($cost_price) && $cost_price!='')?$cost_price:''; }?>
						  	 <?php if(isset($cost_price)) { echo $cost_price; }?> 
						  	 
					   	</div>
						<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1"><strong>Discounted Price</strong></label>
							<?php if(isset($package_details)) { $discounted_price = (isset($discounted_price) && $discounted_price!='')?$discounted_price:$package_details[0]['discounted_price']; } else { $discounted_price = (isset($discounted_price) && $discounted_price!='')?$discounted_price:''; }?>
						  	 <?php if(isset($discounted_price)) { echo $discounted_price; }?> 
						  	 
						  	 
					   	</div>
				  	</div>
					
					<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1"></label>
							<?php if(isset($package_details)) { $is_online = (isset($is_online) && $is_online!='')?$is_online:$package_details[0]['is_online']; } else { $is_online = (isset($is_online) && $is_online!='')?$is_online:''; }?>
						  	 
									<div class=" ">
										 
										<label for="is_online"><strong>Is Online</strong></label>
										<?php if($is_online == 1){ echo "Yes";}else{ echo "N/A";}?>
									</div>
								 
					   	</div>
						<div class="col-md-6">
							<label class="form-control-label" for="inputGrid1"></label>
							<?php if(isset($package_details)) { $is_gst_tax = (isset($is_gst_tax) && $is_gst_tax!='')?$is_gst_tax:$package_details[0]['is_gst_tax']; } else { $is_gst_tax = (isset($is_gst_tax) && $is_gst_tax!='')?$is_gst_tax:''; }?>
						  	 
									<div class=" ">
										 
										<label for="is_gst_tax"><strong>Is GST Tax</strong></label>
										<?php if($is_gst_tax == 1){ echo "Yes";}else{ echo "N/A";}?>
									</div>
								 
					   	</div>
				  	</div>
					
					<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid2"><strong>Redemption Start Date</strong></label>
							<?php if(isset($package_details)) { $start_date = (isset($start_date) && $start_date!='')?$start_date:$package_details[0]['start_date']; } else { $start_date = (isset($start_date) && $start_date!='')?$start_date:''; }?>
							 <?php if(isset($start_date)) { echo $start_date; }?> 
							 
					   	</div>
						<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid2"><strong>Redemption End Date</strong></label>
							<?php if(isset($package_details)) { $expire_date = (isset($expire_date) && $expire_date!='')?$expire_date:$package_details[0]['expire_date']; } else { $expire_date = (isset($expire_date) && $expire_date!='')?$expire_date:''; }?>
							 <?php if(isset($expire_date)) { echo $expire_date; }?> 
							 
					   	</div>
				  	</div>
					
					<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1"><strong>Status</strong></label>
						  	<?php if(isset($package_details)) { $status = (isset($status) && $status!='')?$status:$package_details[0]['status']; } else { $status = (isset($status) && $status!='')?$status:''; }?>
						  	 
		                      	 <?php if(isset($status)){ if($status == '1') { echo "Active"; }} ?> 
		                      	 <?php if(isset($status)){ if($status == '0') { echo "Inactive"; }} ?> 
		                     
					   	</div>
						<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid2"><strong>Photo</strong></label>
							<div class="form-group">
								<div class="input-group input-group-file" data-plugin="inputGroupFile">
								   
								</div>
							</div>
					   	</div>
				  	</div>
					
					<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1"><strong>Package Item</strong></label>
						  	 
							 
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
										<th><strong>Caption</strong></th>
										<th><strong>Service Name</strong></th>
										<th><strong>Price</strong></th>
										<th><strong>Limit</strong></th>
										 
									</thead>
									<tbody class="field_wrapper ">
										<?php if(isset($service_timing_details)) { foreach ($service_timing_details as $key=>$row) { ?>
										
										<tr class="addmore_div" id="<?php echo $row['service_timing_id'] ?>" >
											<td class=" cap"><?php echo getCaptionName($row['service_timing_id']); ?><input type="hidden" name="service_timing_id[]" value="<?php echo $row['service_timing_id'] ?>"></td>
											<td class=" s_name"><?php echo getServiceName($row['service_id']); ?><input type="hidden" name="service_id[]" value="<?php echo $row['service_id'] ?>"></td>
											<td class=" rp"><?php echo $row['amount'] ?><input type="hidden" name="amount[]" value="<?php echo $row['amount'] ?>"></td>
											<td width="100" class=" vl"> <?php echo $row['visit_limit'] ?> </td>
											 
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
                                        
                  </div>
				  
            <!-- End Panel Static Labels -->
          </div>

          		  
        </div>
      </div>
    </div>
</div>
</div>
        <!-- End Page -->

<?php $this->load->view('admin/common/footer'); ?>
 
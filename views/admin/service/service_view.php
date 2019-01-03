<?php $this->load->view('admin/common/header'); ?>
<style>
	.top_line {border-top: 1px solid grey;
	padding-top: 12px;    padding-bottom: 18px;}
	.admin_content_error {width: 100% !important;}
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
      <!-- <div class="page-header">
        <h1 class="page-title">Add New Service</h1>        
        <div class="page-header-actions"><a href="<?php echo base_url('admin/service');?>"><button type="button" class="btn btn-block btn-primary">All Services</button></a></div>
      </div> -->

      	<div class="page-header">
          <ul class="nav nav-tabs" role="tablist">
            	        	<li class="nav-item" role="presentation"><a class="nav-link active"  href="<?php echo base_url('admin/service');?>" >Services</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link " href="<?php echo base_url('admin/service/all_service_category');?>" >Service Categories</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link " data-toggle="tab"  role="tab" href="<?php echo base_url('admin/service/all_service_group');?>" >Service Group</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_packages');?>" >Packages</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link " href="<?php echo base_url('admin/service/all_class');?>" >Class</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link "  href="<?php echo base_url('admin/service/all_class_category');?>" >Class Categories</a></li>
          </ul>
          <div class="page-header-actions">
            <a class="btn btn-info" href="<?php echo base_url('admin/service');?>">All Services</a>
          </div>
        </div>
 

  	<div class="row">
		<div class="col-md-6">
			<div class="panel-body" style="padding: 10px 30px;">
				<h1 class="page-title">Service Info</h1><hr>
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
            <!-- Panel Static Labels -->

            <!-- <div class="panel"> -->

          		<div class="panel-body container-fluid">
                	 
                  		<?php $admin_session = $this->session->userdata('admin_logged_in');
                		if($admin_session['role'] == 'owner') { ?>
                		
            			<div class="form-group  row" data-plugin="formMaterial">
						  <div class="col-md-12">
							  	<label class="form-control-label" for="inputGrid1">Business</label>
							  	<?php $business_id1 = (isset($business_id1) && $business_id1!='')?$business_id1:$service_details[0]['business_id'];?>
						  		 
			                      
			                       <?php if($all_business){?>
			                       <?php foreach($all_business as $business){?>
			                       <?php if(isset($business_id1)){ 
											if($business_id1==$business['id']) { 
												echo $business['name']; 
											}  
										 }?>  
			                       <?php } } ?>
			                     
						   </div>
					  	</div>

					  	<?php } ?>

                  		<div class="form-group  row" data-plugin="formMaterial">
						  	<div class="col-md-12">
						  		<label class="form-control-label" for="inputGrid1"><strong>Service Name</strong></label>
						  		<?php echo $service_name = (isset($service_name) && $service_name!='')?$service_name:$service_details[0]['service_name'];?>
							  	 							  	 
						   	</div>
					  	</div>
					  	<div class="form-group  row" data-plugin="formMaterial">
						  	<div class="col-md-12">
						  		<label class="form-control-label" for="inputGrid1"><strong>SKU</strong></label>
						  		<?php echo $sku = (isset($sku) && $sku!='')?$sku:$service_details[0]['sku'];?> 
							  	 
						   	</div>
					  	</div>

					  	<div class="form-group  row" data-plugin="formMaterial">
						  	<div class="col-md-12">
							 	<label class="form-control-label" for="inputGrid1"><strong>Description</strong></label>
							 	<?php echo $description = (isset($description) && $description!='')?$description:$service_details[0]['description'];?>
		                      	  
					   		</div>
					  	</div>

				  		<div class="form-group  row" data-plugin="formMaterial">
						  	<div class="col-md-12">
							 	<label class="form-control-label" for="inputGrid1"><strong>Service Category</strong></label>
							 	<?php $service_category_id = (isset($service_category_id) && $service_category_id!='')?$service_category_id:$service_details[0]['service_category_id'];?> 
		                      	  
			                       	<?php foreach($all_service_category as $category){?>
			                       	<?php if($service_category_id==$category['id']) { 
										    echo $category['name']; 
									     } 
									}?>
			                       
					   		</div>
					  	</div>


					  	<div class="form-group  row" data-plugin="formMaterial">
						  	<div class="col-md-12">
						  		<?php if(isset($service_details[0]['service_resource_list'])) { 
						  			$temp = $service_details[0]['service_resource_list'];
						  			$arr = explode(',',$temp);
						  	
						  		 } ?>
							 	<label class="form-control-label" for="inputGrid1"><strong>Service Resource</strong></label>
							 	   
								<?php 
								if (isset($all_resources)) {
								foreach($all_resources as $resource){?>			                       	 
								 <?php if(isset($arr)){ 
									$count = count((array)$arr);
									for($i=0;$count>$i;$i++){
										if($arr[$i]==$resource['id']){ 
												echo $resource['resource_name'].','; 
										}
									}
									}?>
								<?php }
								} 
								?>

		                      	  
					   		</div>
					  	</div>

					  	<div class="form-group  row" data-plugin="formMaterial">
						  	<div class="col-md-12">
						  		<?php $is_online = (isset($is_online) && $is_online!='')?$is_online:$service_details[0]['is_online'];?>
								 
								  		<div class=" ">											  
											<label><strong>Is Online</strong></label>
											<?php if(isset($is_online)) { if($is_online == 1) {echo "Yes"; }else{ echo "N/A";} } ?>
								  		</div>
									 
						  	</div>
					  	</div>

					  	<div class="form-group  row" data-plugin="formMaterial">
						  	<div class="col-md-12">
						  		<?php $is_gst_tax = (isset($is_gst_tax) && $is_gst_tax!='')?$is_gst_tax:$service_details[0]['is_gst_tax'];?>
								 
								  		<div class="">											 
											<label><strong>Is GST Tax</strong></label>
											<?php if(isset($is_gst_tax)) { if($is_gst_tax == 1) {echo "Yes"; }else{ echo "N/A";} } ?>
								  		</div>
									 
								 
						  	</div>
					  	</div>

					  	<div class="form-group  row" data-plugin="formMaterial">
						  	<div class="col-md-12">
						  		<?php $is_extra_time = (isset($is_extra_time) && $is_extra_time!='')?$is_extra_time:$service_details[0]['is_extra_time'];?>
								 
								  		<div >
											<label><strong>Is Extra Time</strong></label>
											<?php if(isset($is_extra_time)) { if($is_extra_time == 1) {echo "Yes"; }else{ echo "N/A";} } ?>											
								  		</div>
									 
						  	</div>
					  	</div>

					  	<div class="form-group  row hidecheckbox" data-plugin="formMaterial" >
						  <div class="col-md-12">
						  		<label class="form-control-label" for="inputGrid1"><strong>Extra Time Before</strong></label>
						  		<?php $extra_time_before = (isset($extra_time_before) && $extra_time_before!='')?$extra_time_before:$service_details[0]['extra_time_before'];?>							  								  	 
										<?php 										
										$str = $extra_time_before; $h = explode(":",$str);	$n_h = $h[0] * 60; $n_m = $h[1]; $n_time =$n_h+$n_m; 										
										$i=0;
										for($i=0;$i<=720;$i++) { ?>										 
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
					  	</div>

					  	<div class="form-group  row hidecheckbox" data-plugin="formMaterial">
						  <div class="col-md-12">
						  		<label class="form-control-label" for="inputGrid1"><strong>Extra Time After</strong></label>
						  		<?php $extra_time_after = (isset($extra_time_after) && $extra_time_after!='')?$extra_time_after:$service_details[0]['extra_time_after'];?>							  	 							  	
										<?php 										
										$str = $extra_time_after; $h = explode(":",$str);	$n_h = $h[0] * 60; $n_m = $h[1]; $n_time =$n_h+$n_m; 
										
										$i=0;
										for($i=0;$i<=720;$i++) { ?>
										 
											<?php 
												$h = floor($i / 60);
												$m = floor($i -   floor($i / 60) * 60);
												if($h == 0)
												{
													if($n_time == $i){ echo $hours = ($i - floor($i / 60) * 60)."min";}
												}else if($m == 0) {
													if($n_time == $i){ echo $hours = floor($i / 60)."h "; }
												}else{
													if($n_time == $i){ echo $hours = floor($i / 60)."h ".($i -   floor($i / 60) * 60). "min"; }
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
            <!-- End Panel Static Labels -->
      	<!-- </div> -->

  		<div class="col-md-6">
            <!-- Panel Floating Labels -->
            <div class="panel">
              	
              	<div class="panel-body container-fluid">
                	
                	<!-- <form autocomplete="off" method="post" action="<?php echo base_url('admin/service/edit_service/'.$this->uri->segment('4')); ?>"> -->


            		<input type="hidden" name="service_timing" value="service_timing">
            		<div class="field_wrapper" >
                	<div class="addmore_div " id="addmore_div">
                		
                		<?php $admin_session = $this->session->userdata("admin_logged_in");?>

                		<?php if($service_timing_details) { 
                		foreach($service_timing_details as $row) { ?>

                			<div class="allredy">
	            			<div class="row mb-10" data-plugin="formMaterial">
							   	<div class="col-md-4">
								  	<label class="form-control-label" for="inputGrid1"><strong>Caption</strong></label>
								  	  <?php echo $row['caption']; ?> 
								  	 
							   	</div>
							   	<div class="col-md-4">
								  	<label class="form-control-label" for="inputGrid1"><strong>Duration</strong></label>								  	   
										<?php 										
										$str = $row['duration']; $h = explode(":",$str);	$n_h = $h[0] * 60; $n_m = $h[1]; $n_time =$n_h+$n_m; 										
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
						  </div><hr>

                		<?php  } }  ?>


					</div>
					</div>
					  	<div class="form-group  row" data-plugin="formMaterial">
	                    	               
	                  	</div>
                	<!-- </form> -->
              	</div>
            </div>
            <!-- End Panel Floating Labels -->
      	</div> 
      </div>

    </div>
	 
  	</div>
    </div>
    <!-- End Page -->

<?php $this->load->view('admin/common/footer'); ?>
 
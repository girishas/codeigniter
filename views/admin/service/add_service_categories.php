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
				<li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab"  role="tab" >Service Categories</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_service_group');?>" >Service Group</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_packages');?>" >Packages</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_class');?>" >Class</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link "  href="<?php echo base_url('admin/service/all_class_category');?>" >Class Categories</a></li>
							
			</ul>
	      	<div class="page-header-actions">
	        	<a class="btn btn-info" href="<?php echo base_url('admin/service/all_service_category');?>">All Service Category</a>
	      	</div>
	    </div>	
      	<div class="row">
	      		<div class="col-md-12">
	      			<div class="panel-body" style="padding:10px 30px;">
	      			<h1 class="page-title">Add Service Category</h1><hr>
	      		</div>
      		</div>
      	</div>

        <div class="row">

                     
              <div class="panel-body container-fluid">
                <form autocomplete="off" method="post">

                	<?php $admin_session = $this->session->userdata('admin_logged_in');
            		if($admin_session['role'] == 'owner') { ?>

            		<input type="hidden" name="action" value="save">
            		
        			<div class="form-group  row" data-plugin="formMaterial">
					  <div class="col-md-12">
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
				  	</div>
				  	</div>
				  </div>

				  	<?php } ?>

                  	<div class=" form-group row">
				  		<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1">Service Category Name*</label>
						  	<input type="text" class="form-control" name="name" id="name" >
						  	<div class="admin_content_error"><?php echo form_error('name'); ?></div>
					   	</div>

				  		<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1">Sequence Order*</label>
						  	<input type="Number" class="form-control" name="short_number" id="short_number"  >
						  	<div class="admin_content_error"><?php echo form_error('short_number'); ?></div>
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
    <!-- End Page -->

<?php $this->load->view('admin/common/footer'); ?>
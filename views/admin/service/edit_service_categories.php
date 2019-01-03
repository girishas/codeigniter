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
    
      <!-- <div class="page-header">
        <h1 class="page-title">Add New Service</h1>        
        <div class="page-header-actions"><a href="<?php echo base_url('admin/service');?>"><button type="button" class="btn btn-block btn-primary">All Services</button></a></div>
      </div> -->

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

      <div class="page-content container-fluid">
      	
      	<div class="row">
      		<div class="col-md-12">
      			<h1 class="page-title">Edit Service Category</h1><hr>
      		</div>
      	</div>

     

         
            <!-- Panel Static Labels -->
            <div class="panel">
              
              <div class="panel-body container-fluid">
                
            	<form autocomplete="off" method="post" action="<?php echo base_url('admin/service/edit_service_category/'.$this->uri->segment('4')); ?>">

            		<input type="hidden" name="edit_service_category" value="edit_service_category">

                	<?php $admin_session = $this->session->userdata('admin_logged_in');
            		if($admin_session['role'] == 'owner') { ?>

            		<input type="hidden" name="action" value="save">
            		
        			<div class="form-group  row" data-plugin="formMaterial">
					  <div class="col-md-12">
						  	<label class="form-control-label" for="inputGrid1">Business*</label>
						  	<?php $business_id = (isset($business_id) && $business_id!='')?$business_id:$service_category_details[0]['business_id'];?>
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

                  	<div class=" form-group row" data-plugin="formMaterial">
				  		<div class="col-md-6">
						  	<label class="form-control-label" for="inputGrid1">Service Category Name*</label>
						  	<?php $name = (isset($name) && $name!='')?$name:$service_category_details[0]['name'];?>
						  	<input type="text" class="form-control" name="name" id="name" value="<?php if(isset($name)) { echo $name; }?>" >
						  	<div class="admin_content_error"><?php echo form_error('name'); ?></div>
					   	</div>

              <?php $short_number = (isset($short_number) && $short_number!='')?$short_number:$service_category_details[0]['short_number'];?>
              <div class="col-md-6">
                <label class="form-control-label" for="inputGrid1">Sequence Order*</label>
                <input type="Number" class="form-control" name="short_number" id="short_number" value="<?php if(isset($short_number)) { echo $short_number; }?>"   >
                <div class="admin_content_error"><?php echo form_error('short_number'); ?></div>
              </div>
             </div>


				  
            <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <button class="btn btn-primary" data-dismiss="modal" type="submit">Save</button>
                    </div>                    
                  </div>
				  
                  
				<!--   <div class="row" data-plugin="formMaterial">
                    <div class="col-md-12">
                      <button class="btn btn-primary" data-dismiss="modal" type="submit">Save</button>
                    </div>                    
                  </div>
 -->				  
                </form>
              </div>
          
            <!-- End Panel Static Labels -->
          </div>

        </div>
      </div>
    </div>
  </div>
    <!-- End Page -->

<?php $this->load->view('admin/common/footer'); ?>
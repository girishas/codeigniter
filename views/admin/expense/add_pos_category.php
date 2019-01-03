<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/admin_custom.css');?>">

<?php $this->load->view('admin/common/left_menubar'); ?>  
 <!-- Page -->
    <div class="page">
    	<div class="page-content">
    	<div class="panel">	
	  	<div class="page-header">
	      	<ul class="nav nav-tabs" role="tablist">
				
				              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense');?>">Open Register</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/today_sale');?>">Today Position</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link " href="<?php echo base_url('admin/expense/close_register');?>">Close Register</a></li> 
                      <!-- <li class="nav-item dropdown" style="float:left;" role="presentation"><a class="nav-link"  href="<?php echo base_url('admin/expense/today_sale');?>">Today Position</a>
                      <?php if($admin_session['role']=="owner" || $admin_session['role']=="business_owner"){ ?>  
                        <div class="dropdown-content">
                           <?php if(isset($locations)){?>
                              <?php foreach($locations as $loc){?>
                                <a href="<?php echo base_url('admin/expense/today_sale/').$loc['id'];?>"><?php echo $loc['location_name'];?></a>
                          <?php } } ?>
                        </div>
                      <?php } ?>  
                      </li>
                      <li class="nav-item dropdown" style="float:left;" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/close_register');?>">Close Register</a>
                      <?php if($admin_session['role']=="owner" || $admin_session['role']=="business_owner"){ ?>  
                        <div class="dropdown-content">
                           <?php if(isset($locations)){?>
                              <?php foreach($locations as $loc){?>
                                <a href="<?php echo base_url('admin/expense/close_register/').$loc['id'];?>"><?php echo $loc['location_name'];?></a>
                          <?php } } ?>
                        </div>
                      <?php } ?>
                      </li> -->
                      <li class="nav-item" role="presentation"><a class="nav-link " href="<?php echo base_url('admin/expense/all_expenses');?>">Expense</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" role="tab" href="<?php echo base_url('admin/expense/all_pos_category');?>">Pos Category</a></li>
                     <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/all_vendors');?>">Vendor</a></li>
							
			</ul>
	      	<div class="page-header-actions">
	        	<a class="btn btn-info" href="<?php echo base_url('admin/expense/all_pos_category');?>">All Pos Category</a>
	      	</div>
	    </div>	
      	<div class="row">
	      		<div class="col-md-6">
	      			<div class="panel-body" style="padding:10px 30px;">
	      			<h1 class="page-title">Add Pos Category</h1><hr>
	      		</div>
      		</div>
      	</div>

        <div class="row">

          <div class="col-md-6">              
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

				  	<?php } ?>

                  	<div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-12">
						  	<label class="form-control-label" for="inputGrid1">Pos Category Name*</label>
						  	<input type="text" class="form-control" name="name" id="name" >
						  	<div class="admin_content_error"><?php echo form_error('name'); ?></div>
					   	</div>
				  	</div>

				  	<div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Status</label>
                                            <div class="form-group">
                        <select class="form-control" name="status" id="status">
                          	<option value="">Select Status</option>
                           	<option value="1" selected="">Active</option>
                           	<option value="0">Inactive</option>
                        </select>
                        <div class="admin_content_error"></div>
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
            <!-- End Panel Static Labels -->
          </div>
      </div>
    </div>
</div>
</div>
    <!-- End Page -->

<?php $this->load->view('admin/common/footer'); ?>
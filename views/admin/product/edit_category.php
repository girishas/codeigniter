<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
<?php $this->load->view('admin/common/left_menubar'); ?>  
  <!-- Page -->
 <!-- Page -->
    <div class="page">
       <?php $this->load->view('admin/common/header_messages'); ?>
	  <div class="page-content container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Panel Static Labels -->
            <div class="panel">
               
			    <div class="page-header">
				  <?php $this->load->view('admin/product/inventry_top'); ?>
				  <div class="page-header-actions"><h3 class="panel-title">Edit Product Category</h3></div>
				</div>
			  <div class="panel-body container-fluid">
                <form autocomplete="off" method="post" action="">
                 <input type="hidden" name="action" value="save"> 
                  <?php if($admin_session['role']=="owner" || $admin_session['role']=="business_owner"){?>				  
				  <?php $business_id_value = (isset($business_id) && $business_id!='')?$business_id:$category_detail[0]['business_id'];?>				  
				  <div class="form-group  row" data-plugin="formMaterial">
                    <?php if($admin_session['role']=="owner"){?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Business*</label>                      
				    <select class="form-control" name="business_id" id="business_id" onChange="return get_business_locations(this.value)">
					  <option value="">Select Business</option>
						   <?php if($all_business){?>
						   <?php foreach($all_business as $business){?>
						   <option value="<?php echo $business['id'];?>" <?php if(isset($business_id_value) && $business_id_value==$business['id']) echo "selected"; ?>><?php echo $business['name'];?></option>
						   <?php } } ?>
					</select>
					<div class="admin_content_error"><?php echo form_error('business_id'); ?></div>
                    </div>
					<?php } ?>
					
                    <!--<div class="col-md-6" id="location_section">
                       < ?php $location_id_value = (isset($location_id) && $location_id!='')?$location_id:$category_detail[0]['location_id'];?>
					  <label class="form-control-label" for="inputGrid2">Location*</label>
                       <span id="content_location_id">
					   <select class="form-control" name="location_id" id="location_id">
					   	<option value="">Select Location</option>
						< ?php if(isset($locations)){?>
						< ?php foreach($locations as $loc){?>
							<option value="< ?php echo $loc['id'];?>" < ?php if(isset($location_id_value) && $location_id_value==$loc['id']) echo "selected"; ?>>< ?php echo $loc['location_name'];?></option>
						< ?php } } ?>
					   </select>
					  </span>
					  <div class="admin_content_error">< ?php echo form_error('location_id'); ?></div>
                    </div>-->
                  </div>
				  <?php } ?>
				  <div class="form-group  row" data-plugin="formMaterial">
                    <?php $category_name_value = (isset($category_name) && $category_name!='')?$category_name:$category_detail[0]['category_name'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Category Name</label>
                      <input type="text" name="category_name" id="category_name" class="form-control" value="<?php if(isset($category_name_value)) echo $category_name_value;?>">
					  <div class="admin_content_error"><?php echo form_error('category_name'); ?></div>
                    </div>
                  </div>
                   <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $category_code = (isset($category_code) && $category_code!='')?$category_code:$category_detail[0]['category_code'];?>
					  <label class="form-control-label" for="inputGrid1">Category Name</label>
                      <input type="text" name="category_code" id="category_code" class="form-control" value="<?php if(isset($category_code)) echo $category_code; ?>" maxlength="200" >
					  <div class="admin_content_error">
							<?php echo form_error('category_code'); ?>
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

         
          </div>
        </div>
      </div>
    </div>
    <!-- End Page -->
  <!-- End page -->

<?php $this->load->view('admin/common/footer'); ?>
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
				  <div class="page-header-actions"><h3 class="panel-title">Add Supplier</h3></div>
				</div>
			  <div class="panel-body container-fluid">
                <form autocomplete="off" action="" method="post">
                   <input type="hidden" name="action" value="save"> 
                  <?php if($admin_session['role']=="owner" || $admin_session['role']=="business_owner"){?>
				  <div class="form-group  row" data-plugin="formMaterial">
                    <?php if($admin_session['role']=="owner"){?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Business*</label>                      
				    <select class="form-control" name="business_id" id="business_id" onChange="return get_business_locations(this.value)">
					  <option value="">Select Business</option>
						   <?php if($all_business){?>
						   <?php foreach($all_business as $business){?>
						   <option value="<?php echo $business['id'];?>" <?php if(isset($business_id) && $business_id==$business['id']) echo "selected"; ?>><?php echo $business['name'];?></option>
						   <?php } } ?>
					</select>
					<div class="admin_content_error"><?php echo form_error('business_id'); ?></div>
                    </div>
					<?php } ?>
					
                    <!--<div class="col-md-6" id="location_section">
                      <label class="form-control-label" for="inputGrid2">Location*</label>
                       <span id="content_location_id">
					   <select class="form-control" name="location_id" id="location_id">
					   	<option value="">Select Location</option>
						< ?php if(isset($locations)){?>
						< ?php foreach($locations as $loc){?>
							<option value="< ?php echo $loc['id'];?>" < ?php if(isset($location_id) && $location_id==$loc['id']) echo "selected"; ?>>< ?php echo $loc['location_name'];?></option>
						< ?php } } ?>
					   </select>
					  </span>
					  <div class="admin_content_error">< ?php echo form_error('location_id'); ?></div>
                    </div>-->
                  </div>
				  <?php } ?>
            <div class="form-group row">
               <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid1">Company Name</label>
                    <input type="text" class="form-control" id="supplier_company_name" name="supplier_company_name" value="<?php if(isset($supplier_company_name)) echo $supplier_company_name;?>">
                </div>
                <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid1">Abn Number</label>
                    <input type="text" class="form-control" id="supplier_abn" name="supplier_abn" value="<?php if(isset($supplier_abn)) echo $supplier_abn;?>">
                </div>
            </div>
                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">First Name*</label>
                      <input type="text" class="form-control" id="first_name" name="first_name" value="<?php if(isset($first_name)) echo $first_name;?>">
                      <div class="admin_content_error"><?php echo form_error('first_name'); ?></div>
					</div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Last Name</label>
                      <input type="text" class="form-control" id="last_name" name="last_name" value="<?php if(isset($last_name)) echo $last_name;?>"  />
                    </div>
                  </div>
				  
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Email*</label>
                      <input type="text" class="form-control" id="email" name="email" value="<?php if(isset($email)) echo $email;?>">
					  <div class="admin_content_error"><?php echo form_error('email'); ?></div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Mobile Number*</label>
                      <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php if(isset($mobile_number)) echo $mobile_number;?>" />
					   <div class="admin_content_error"><?php echo form_error('mobile_number'); ?></div>
                    </div>
                  </div>
				   <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">City*</label>
                      <input type="text" class="form-control" id="city" name="city" value="<?php if(isset($city)) echo $city;?>" />
            <div class="admin_content_error"><?php echo form_error('city'); ?></div>
                    </div>
                  </div>
				   <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Address1</label>
                      <input type="text" class="form-control" id="address1" name="address1" value="<?php if(isset($address1)) echo $address1;?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Address2</label>
                      <input type="text" class="form-control" id="address2" name="address2" value="<?php if(isset($address2)) echo $address2;?>" />
                    </div>
                  </div>
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">State</label>
                      <input type="text" class="form-control" id="state" name="state" value="<?php if(isset($state)) echo $state;?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Post Code</label>
                      <input type="text" class="form-control" id="postcode" name="postcode" value="<?php if(isset($postcode)) echo $postcode;?>">
                    </div>
                  </div>
				 
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Country</label>
                        <div class="form-group">
						<select class="form-control" name="country_id" id="country_id">
						  <option>Select Country</option>
						  <?php if($all_countries){?>
						  <?php foreach($all_countries as $country){?>
						   <option value="<?php echo $country['iso_code'];?>" <?php if(isset($country_id) && $country_id==$country['iso_code']) echo "selected"; ?>><?php echo $country['name'];?></option>
						  <?php } } ?>
						</select>
					  </div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Website</label>
                      <input type="text" class="form-control" id="website" name="website" value="<?php if(isset($website)) echo $website;?>">
                    </div>
                  </div>
				  
				   <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Description</label>
                     <textarea class="form-control" name="description" id="description" rows="3"><?php if(isset($description)) echo $description;?></textarea>
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
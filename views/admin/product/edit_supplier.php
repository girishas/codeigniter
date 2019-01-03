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
				  <div class="page-header-actions"><h3 class="panel-title">Edit Supplier</h3></div>
				</div>
			  <div class="panel-body container-fluid">
                <form autocomplete="off" action="" method="post">
                   <input type="hidden" name="action" value="save"> 
                   <?php if($admin_session['role']=="owner" || $admin_session['role']=="business_owner"){?>				  
				  <?php $business_id_value = (isset($business_id) && $business_id!='')?$business_id:$supplier_detail[0]['business_id'];?>				  
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
                       < ?php $location_id_value = (isset($location_id) && $location_id!='')?$location_id:$supplier_detail[0]['location_id'];?>
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
          <div class="form-group row">
            <div class="col-md-6">
                <?php $supplier_company_name = (isset($supplier_company_name) && $supplier_company_name!='')?$supplier_company_name:$supplier_detail[0]['supplier_company_name'];?>
      <label class="form-control-label" for="inputGrid1">Company Name</label>
                <input type="text" class="form-control" id="supplier_company_name" name="supplier_company_name" value="<?php if(isset($supplier_company_name)) echo $supplier_company_name;?>">
              </div>

              <div class="col-md-6">
                <?php $supplier_abn = (isset($supplier_abn) && $supplier_abn!='')?$supplier_abn:$supplier_detail[0]['supplier_abn'];?>
      <label class="form-control-label" for="inputGrid1">Abn Number</label>
                <input type="text" class="form-control" id="supplier_abn" name="supplier_abn" value="<?php if(isset($supplier_abn)) echo $supplier_abn;?>">
              </div>
          </div>
                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $first_name_value = (isset($first_name) && $first_name!='')?$first_name:$supplier_detail[0]['first_name'];?>
					  <label class="form-control-label" for="inputGrid1">First Name*</label>
                      <input type="text" class="form-control" id="first_name" name="first_name" value="<?php if(isset($first_name_value)) echo $first_name_value;?>">
                      <div class="admin_content_error"><?php echo form_error('first_name'); ?></div>
					</div>
                    <div class="col-md-6">
                       <?php $last_name_value = (isset($last_name) && $last_name!='')?$last_name:$supplier_detail[0]['last_name'];?>
					  <label class="form-control-label" for="inputGrid2">Last Name</label>
                      <input type="text" class="form-control" id="last_name" name="last_name" value="<?php if(isset($last_name_value)) echo $last_name_value;?>"  />
                    </div>
                  </div>
				  
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $email_value = (isset($email) && $email!='')?$email:$supplier_detail[0]['email'];?>
					  <label class="form-control-label" for="inputGrid1">Email*</label>
                      <input type="text" class="form-control" id="email" name="email" value="<?php if(isset($email_value)) echo $email_value;?>">
					  <div class="admin_content_error"><?php echo form_error('email'); ?></div>
                    </div>
                    <div class="col-md-6">
                      <?php $mobile_number_value = (isset($mobile_number) && $mobile_number!='')?$mobile_number:$supplier_detail[0]['mobile_number'];?>
					  <label class="form-control-label" for="inputGrid2">Mobile Number*</label>
                      <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php if(isset($mobile_number_value)) echo $mobile_number_value;?>" />
					   <div class="admin_content_error"><?php echo form_error('mobile_number'); ?></div>
                    </div>
                  </div>
				    <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                       <?php $city_value = (isset($city) && $city!='')?$city:$supplier_detail[0]['city'];?>
            <label class="form-control-label" for="inputGrid2">City*</label>
                      <input type="text" class="form-control" id="city" name="city" value="<?php if(isset($city_value)) echo $city_value;?>" />
            <div class="admin_content_error"><?php echo form_error('city'); ?></div>
                    </div>
                  </div>
				   <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $address1_value = (isset($address1) && $address1!='')?$address1:$supplier_detail[0]['address1'];?>
					  <label class="form-control-label" for="inputGrid1">Address1</label>
                      <input type="text" class="form-control" id="address1" name="address1" value="<?php if(isset($address1_value)) echo $address1_value;?>">
                    </div>
                    <div class="col-md-6">
                      <?php $address2_value = (isset($address2) && $address2!='')?$address2:$supplier_detail[0]['address2'];?>
					  <label class="form-control-label" for="inputGrid2">Address2</label>
                      <input type="text" class="form-control" id="address2" name="address2" value="<?php if(isset($address2_value)) echo $address2_value;?>" />
                    </div>
                  </div>
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $state_value = (isset($state) && $state!='')?$state:$supplier_detail[0]['state'];?>
					  <label class="form-control-label" for="inputGrid1">State</label>
                      <input type="text" class="form-control" id="state" name="state" value="<?php if(isset($state_value)) echo $state_value;?>">
                    </div>
                    <div class="col-md-6">
                      <?php $postcode_value = (isset($postcode) && $postcode!='')?$postcode:$supplier_detail[0]['postcode'];?>
					  <label class="form-control-label" for="inputGrid1">Post Code</label>
                      <input type="text" class="form-control" id="postcode" name="postcode" value="<?php if(isset($postcode_value)) echo $postcode_value;?>">
                    </div>
                  </div>
				 
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $country_id_value = (isset($country_id) && $country_id!='')?$country_id:$supplier_detail[0]['country_id'];?>
					  <label class="form-control-label" for="inputGrid1">Country</label>
                        <div class="form-group">
						<select class="form-control" name="country_id" id="country_id">
						  <option>Select Country</option>
						  <?php if($all_countries){?>
						  <?php foreach($all_countries as $country){?>
						   <option value="<?php echo $country['iso_code'];?>" <?php if(isset($country_id_value) && $country_id_value==$country['iso_code']) echo "selected"; ?>><?php echo $country['name'];?></option>
						  <?php } } ?>
						</select>
					  </div>
                    </div>
                    <div class="col-md-6">
                      <?php $website_value = (isset($website) && $website!='')?$website:$supplier_detail[0]['website'];?>
					  <label class="form-control-label" for="inputGrid1">Website</label>
                      <input type="text" class="form-control" id="website" name="website" value="<?php if(isset($website_value)) echo $website_value;?>">
                    </div>
                  </div>
				 
				   <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                       <?php $description_value = (isset($description) && $description!='')?$description:$supplier_detail[0]['description'];?>
					  <label class="form-control-label" for="inputGrid1">Description</label>
                     <textarea class="form-control" name="description" id="description" rows="3"><?php if(isset($description_value)) echo $description_value;?></textarea>
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
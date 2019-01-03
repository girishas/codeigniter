<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
<?php $this->load->view('admin/common/left_menubar'); ?>  
  <!-- Page -->
    <div class="page">
      <?php $this->load->view('admin/common/header_messages'); ?>
	  <div class="page-content container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Panel Static Labels -->
            <div class="panel">
              <div class="panel-heading">
                <h3 class="panel-title">Edit Profile</h3>
              </div>
              <div class="panel-body container-fluid">
               <form autocomplete="off" method="post" action="" enctype="multipart/form-data">    
                   <input type="hidden" name="action" value="save"> 
				  <div class="form-group  row" data-plugin="formMaterial">
                    <?php $first_name_value = (isset($first_name) && $first_name!='')?$first_name:$staff_detail[0]['first_name'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">First Name*</label>
                      <input type="text" class="form-control" name="first_name" id="first_name" value="<?php if(isset($first_name_value)) echo $first_name_value;?>">
                   	  <div class="admin_content_error"><?php echo form_error('first_name'); ?></div>
				    </div>
                    <?php $last_name_value = (isset($last_name) && $last_name!='')?$last_name:$staff_detail[0]['last_name'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Last Name</label>
                      <input type="text" class="form-control" name="last_name" id="last_name" value="<?php if(isset($last_name_value)) echo $last_name_value;?>"  />
                    </div>
                  </div>
				  
				   <div class="form-group  row" data-plugin="formMaterial">
                    <?php $email_value = (isset($email) && $email!='')?$email:$staff_detail[0]['email'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Email*</label>
                      <input type="text" class="form-control" name="email" id="email" value="<?php if(isset($email_value)) echo $email_value;?>">
                      <div class="admin_content_error"><?php echo form_error('email'); ?></div>
					</div>
                    <?php $mobile_number_value = (isset($mobile_number) && $mobile_number!='')?$mobile_number:$staff_detail[0]['mobile_number'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Mobile Number*</label>
                      <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php if(isset($mobile_number_value)) echo $mobile_number_value;?>" />
                   	  <div class="admin_content_error"><?php echo form_error('mobile_number'); ?></div>
				    </div>
                  </div>
				  <div class="form-group  row" data-plugin="formMaterial">
                    <?php $address1_value = (isset($address1) && $address1!='')?$address1:$staff_detail[0]['address1'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Street/area</label>
                      <input type="text" class="form-control" name="address1" id="address1" value="<?php if(isset($address1_value)) echo $address1_value;?>">
                    </div>
                    <?php $city_value = (isset($city) && $city!='')?$city:$staff_detail[0]['city'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">City*</label>
                      <input type="text" class="form-control" id="city" name="city" value="<?php if(isset($city_value)) echo $city_value;?>" />
                      <div class="admin_content_error"><?php echo form_error('city'); ?></div>
                    </div>
                  </div>
				  				  
				  <div class="form-group  row" data-plugin="formMaterial">
                    <?php $state_value = (isset($state) && $state!='')?$state:$staff_detail[0]['state'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">State</label>
                      <input type="text" class="form-control" name="state" id="state" value="<?php if(isset($state_value)) echo $state_value;?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Country*</label>
                      <?php $country_id_value = (isset($country_id) && $country_id!='')?$country_id:$staff_detail[0]['country_id'];?>
					  <div class="form-group">
						<select class="form-control" name="country_id" id="country_id">
						  <option value="">Select Country</option>
						  <?php if($all_countries){?>
						  <?php foreach($all_countries as $country){?>
						   <option value="<?php echo $country['iso_code'];?>" <?php if(isset($country_id_value) && $country_id_value==$country['iso_code']) echo "selected";?>><?php echo $country['name'];?></option>
						  <?php } } ?>
						</select>
						<div class="admin_content_error"><?php echo form_error('country_id'); ?></div>
					  </div>
                    </div>
                  </div>
				  <div class="form-group  row" data-plugin="formMaterial">
                    <?php $post_code_value = (isset($post_code) && $post_code!='')?$post_code:$staff_detail[0]['post_code'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Post Code</label>
                      <input type="text" class="form-control" id="post_code" name="post_code" value="<?php if(isset($post_code_value)) echo $post_code_value;?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Profile Picture</label>
                      <div class="form-group">
            <div class="input-group input-group-file" data-plugin="inputGroupFile">
              <input type="text" class="form-control" readonly="">
              <span class="input-group-append">
              <span class="btn btn-success btn-file">
                <i class="icon md-upload" aria-hidden="true"></i>
                <input type="file" name="image" multiple="">
              </span>
              </span>
            </div>
            <?php if(!empty($staff_detail[0]['picture'])){?>
              <img id="img_1" src="<?php echo base_url('images/staff/thumb/'.$staff_detail[0]['picture']); ?>" width="50px;" style="margin-top:2px;" />
              <?php }else{?>
              <img id="img_1" class="img-fluid" src="<?php echo base_url('global/product/no-product-image.jpg');?>" width="50px;" style="margin-top:2px;">
              <?php }?>
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
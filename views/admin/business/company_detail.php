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
      <!-- Alert message part -->
      <?php if($this->session->flashdata('success_msg')) {?>
        <div class="alert dark alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
          <?php echo $this->session->flashdata('success_msg');?>
        </div>
         
      <?php } ?>
      <!-- End alert message part -->
      <div class="page-content container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Panel Static Labels -->
            <div class="panel">
               <div class="page-header">
			  <h3 class="panel-title ">Company Details</h3>
			  <div class="page-header-actions">
				<a href="<?php echo base_url('admin/setup');?>"><button type="button" class="btn btn-block btn-primary">Setup</button></a>  </div>
			  </div>
              <div class="panel-body container-fluid">
                <form name="busniess_add_edit" method="post" id="busniess_add_edit" action="<?php echo base_url(); ?>/admin/business/insertandupdate" enctype="multipart/form-data" autocomplete="off">
                 
					<div class="form-group  row " data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $name = (isset($name) && $name!='')?$name:$business_details['name'];?>
                      <label class="form-control-label" for="inputGrid1">Business Name*</label>
                      <input type="text" class="form-control" id="name" name="name" value="<?php if(isset($name)) echo $name; ?>">
                      <div class="admin_content_error"><?php echo form_error('name'); ?></div>
                    </div>

                     <div class="col-md-6">
                      <?php $abn_number = (isset($abn_number) && $abn_number!='')?$abn_number:$business_details['abn_number'];?>
                      <label class="form-control-label" for="inputGrid1">ABN Number*</label>
                      <input type="text" class="form-control" id="abn_number" name="abn_number" value="<?php if(isset($abn_number)) echo $abn_number; ?>" maxlength="13">
                      <div class="admin_content_error"><?php echo form_error('abn_number'); ?></div>
                    </div>


                   
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                       <?php $phone_number_value = (isset($phone_number) && $phone_number!='')?$phone_number:$business_details['phone_number'];?>
                       <label class="form-control-label" for="inputGrid2">Phone Number</label>
                      <input type="text" class="form-control" id="phone_number" name="phone_number"  value="<?php if(isset($phone_number_value)) echo $phone_number_value; ?>" />       
                    </div>
                    <div class="col-md-6">
                         <label class="form-control-label" for="inputGrid2">Business Category</label>
                      <div class="form-group">
                        <select class="form-control" name="business_category_id" id="business_category_id">
                          <option>Select Category</option>
                                      <?php foreach($business_cats as $cats) { 
                          $business_category_id = ($business_details)?$business_details['business_category_id']:0;
                          ?>
                          <option value="<?php echo $cats['id']; ?>" <?php if($cats['id']==$business_category_id) echo "selected";?>><?php echo $cats['name']; ?></option>
                                      <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group  row " data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $owner_first_name_value = (isset($owner_first_name) && $owner_first_name!='')?$owner_first_name:$business_details['owner_first_name'];?>
                      <label class="form-control-label" for="inputGrid1">Owner First Name*</label>
                      <input type="text" class="form-control" id="owner_first_name" name="owner_first_name" value="<?php if(isset($owner_first_name_value)) echo $owner_first_name_value; ?>">
                      <div class="admin_content_error"><?php echo form_error('owner_first_name'); ?></div>
                    </div>
                    <div class="col-md-6">
                      <?php $owner_last_name_value = (isset($owner_last_name) && $owner_last_name!='')?$owner_last_name:$business_details['owner_last_name'];?>
                      <label class="form-control-label" for="inputGrid2">Owner Last Name</label>
                      <input type="text" class="form-control" id="owner_last_name" name="owner_last_name" value="<?php if(isset($owner_last_name_value)) echo $owner_last_name_value; ?>" />
                    </div>
                  </div>
				          
                   <div class="form-group  row " data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Email*</label>
                      <?php $email_value = (isset($email) && $email!='')?$email:$business_details['email'];?>
                      <input type="text" class="form-control" id="email" name="email" value="<?php if(isset($email_value)) echo $email_value; ?>" >
                       <div class="admin_content_error"><?php echo form_error('email'); ?></div>
                    </div>

                     <div class="col-md-6">
                      <?php $website_value = (isset($website) && $website!='')?$name:$business_details['website'];?>
                        <label class="form-control-label" for="inputGrid2">Website</label>
                        <input type="text" class="form-control" id="website" name="website" value="<?php if(isset($website_value)) echo $website_value; ?>"  />
                    </div>

                    <!--  <div class="col-md-6">
                     <label class="form-control-label" for="inputGrid2">Password</label>
                      <input type="password" class="form-control" name="password" id="password" name="inputGrid2"  />
                    </div> -->
                  </div>


                  <h3 class="panel-title ">Address</h3>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Street/area*</label>
                     <?php $address1_value = (isset($address1) && $address1!='')?$address1:$business_details['address1'];?>
                      <input type="text" class="form-control" id="address1" name="address1" value="<?php if(isset($address1_value)) echo $address1_value; ?>">
                      <div class="admin_content_error"><?php echo form_error('address1'); ?></div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Subrub*</label>
                       <?php $city_value = (isset($city) && $city!='')?$city:$business_details['city'];?>
                      <input type="text" class="form-control" id="city" name="city"value="<?php if(isset($city_value)) echo $city_value; ?>" />
                      <div class="admin_content_error"><?php echo form_error('city'); ?></div>
                    </div>
                  </div>

                  <div class="form-group  row " data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $state_value = (isset($state) && $state!='')?$state:$business_details['state'];?>
                      <label class="form-control-label" for="inputGrid1">State</label>
                      <input type="text" class="form-control" id="state" name="state" value="<?php if(isset($state_value)) echo $state_value; ?>" >
                    </div>
                    <div class="col-md-6">
                      <?php $post_code_value = (isset($post_code) && $post_code!='')?$post_code:$business_details['post_code'];?>
                      <label class="form-control-label" for="inputGrid1">Post Code</label>
                      <input type="text" class="form-control" id="post_code" name="post_code" value="<?php if(isset($post_code_value)) echo $post_code_value; ?>" >
                    </div>  
                  </div>


                   <div class="form-group  row " data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Country*</label>
                      <div class="form-group">
                         <!-- <?php $country_id_value = (isset($country_id) && $country_id!='')?$country_id:$business_details['country_id'];?>
                          <select class="form-control" name="country_id">
                            <option value="">Select Country</option>
                            <?php if($all_countries){?>
                            <?php foreach($all_countries as $country){?>
                            <option value="<?php echo $country['country_id'];?>" <?php if($country_id_value==$country['country_id']) echo "selected";?>><?php echo $country['name'];?></option>
                            <?php } } ?>
                          </select> -->
                         <select class="form-control" name="country_id" id="country_id">
                          <option value="">Select Country</option>
                          <?php if($all_countries){?>
                          <?php foreach($all_countries as $country){
                              $country_id = ($business_details)?$business_details['country_id']:0;
                          ?>
                           <option value="<?php echo $country['country_id'];?>" <?php if($country['country_id']==$country_id) echo "selected";?>><?php echo $country['name'];?></option>
                          <?php } } ?>
                        </select>
                      <div class="admin_content_error"><?php echo form_error('country_id'); ?></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Currency</label>
                      <div class="form-group">
                        <select class="form-control" name="currency_id" id="currency_id">
                          <?php foreach($currencies as $currency) { 
                          $currency_id = ($business_details)?$business_details['currency_id']:0;
                          ?>
                          <option value="<?php echo $currency['id']; ?>" <?php if($currency['id']==$currency_id) echo "selected";?>><?php echo $currency['symbol'].' '.$currency['name']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group  row " data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Time zone</label>
                      <select class="form-control" name="time_zone_id" data-plugin="select2" id="time_zone_id">
                          <?php foreach($time_zones as $key => $val) { 
                          $time_zone_id = ($business_details)?$business_details['time_zone_id']:0;
                          ?>
                          <option value="<?php echo $key; ?>" <?php if($key==$time_zone_id) echo "selected";?>><?php echo $val; ?></option>
                          <?php } ?>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Time Format</label>
                      <div class="form-group">
                        <?php $time_format = ($business_details)?$business_details['time_format']:'';?>
                        <select class="form-control" name="time_format" id="time_format">
                          <option value="12-hours" <?php if($time_format == '12-hours') echo "selected"; ?>>12 hours</option>
                          <option value="24-hours" <?php if($time_format == '24-hours') echo "selected"; ?>>24 hours</option>
                        </select>
                      </div>
                    </div>
                  </div>


                  <h3 class="panel-title ">Business Description</h3>


                  <div class="form-group  row " data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $description_value = (isset($description) && $description!='')?$description:$business_details['description'];?>
                      <label class="form-control-label" for="inputGrid1">Description</label>
                      <textarea class="form-control" id="description" name="description" rows="3" ><?php echo $description_value;?></textarea>
                    </div>
                    <div class="col-md-6">
                       
                    </div>
                  </div>


                  <h3 class="panel-title ">Business Logo</h3>


                  <div class="form-group  row " data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Business Logo</label>
                      <div class="form-group">
                        <div class="input-group input-group-file" data-plugin="inputGroupFile">
                          <input type="text" class="form-control" readonly>
                          <span class="input-group-append">
                            <span class="btn btn-success btn-file">
                              <i class="icon md-upload" aria-hidden="true"></i>
                              <input type="file" name="logo" id="logo" multiple>
                            </span>
                          </span>
                        </div>
                      </div>
                    </div>
                      <div class="col-md-6">
                      </div>
                  </div>


                  <h3 class="panel-title ">Get Social</h3>

                  <div class="form-group  row " data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $facebook_url_value = (isset($facebook_url) && $facebook_url!='')?$facebook_url:$business_details['facebook_url'];?>
                      <label class="form-control-label" for="inputGrid1">Facebook Url</label>
                      <input type="text" class="form-control" id="facebook_url" name="facebook_url"  value="<?php if(isset($facebook_url_value)) echo $facebook_url_value; ?>" >
                    </div>
                    <div class="col-md-6">
                      <?php $twitter_url_value = (isset($twitter_url) && $twitter_url!='')?$twitter_url:$business_details['twitter_url'];?>
                      <label class="form-control-label" for="inputGrid2">Twitter Url</label>
                      <input type="text" class="form-control" id="twitter_url" name="twitter_url" value="<?php if(isset($twitter_url_value)) echo $twitter_url_value; ?>" />
                    </div>
                  </div>

		  
                  <input type="hidden" name="business_id" value="<?php echo ($business_details)?$business_details['id']:0; ?>" />
				            
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
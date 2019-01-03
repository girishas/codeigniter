<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
<?php $this->load->view('admin/common/left_menubar'); ?>  
  <!-- Page -->
    <div class="page">
	
	<!-- Alert message part -->
	 <?php $this->load->view('admin/common/header_messages'); ?>
	<!-- End alert message part -->
	
      <div class="page-content container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Panel Static Labels -->
            <div class="panel">
              <div class="panel-heading">
                <h3 class="panel-title ">Business Details</h3>
				<div class="page-header-actions"><a href="<?php echo base_url('admin/business');?>">
          <button type="button" class="btn btn-block btn-primary">All Business</button></a>
        </div>
              </div>

              

              <div class="panel-body container-fluid">
                <form autocomplete="off" method="post" action="" enctype="multipart/form-data">
                  <input type="hidden" name="action" value="save"> 

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Business Name*</label>
                      <input type="text" name="name" id="name" class="form-control" value="<?php if(isset($name)) { echo $name; } ?>" >
                       <div class="admin_content_error"><?php echo form_error('name'); ?></div>
                    </div>
                    <div class="col-md-6">

                      
                       <label class="form-control-label" for="inputGrid2">ABN Number*</label>
                      <input type="text" class="form-control" id="abn_number" name="abn_number" value="<?php if(isset($abn_number)) { echo $abn_number; } ?>" maxlength="13"/>
                      <div class="admin_content_error"><?php echo form_error('abn_number'); ?>
                        
                      </div>
                  </div>
                  </div>
                    <!-- </div> -->

                      <!-- <label class="form-control-label" for="inputGrid2">Website</label>
                      <input type="text" class="form-control" id="website" name="website" value="<?php if(isset($website)) { echo $website; } ?>" /> -->



                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid2">Website</label>
                      <input type="text" class="form-control" id="website" name="website" value="<?php if(isset($website)) { echo $website; } ?>" />
                    </div>

                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Phone Number</label>
                      <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?php if(isset($phone_number)) { echo $phone_number; } ?>" />
                    </div>
                   
                  </div>


                  <div class="form-group  row" data-plugin="formMaterial">
                     <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Business Category</label>
                      <div class="form-group">
                        <select class="form-control" name="business_category_id" id="business_category_id">
                          <option>Select Category</option>
                          <?php if($all_categories){?>
                           <?php foreach($all_categories as $cat){?>
                           <option <?php if(isset($business_category_id)){ if($business_category_id == $cat['id']) { echo "selected"; } } ?> value="<?php echo $cat['id'];?>"><?php echo $cat['name'];?></option>
                           <?php } } ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Owner First Name*</label>
                      <input type="text" class="form-control" id="owner_first_name" name="owner_first_name" value="<?php if(isset($owner_first_name)) { echo $owner_first_name; } ?>" >
                      <div class="admin_content_error"><?php echo form_error('owner_first_name'); ?></div>
                    </div>
                  
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                      <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Owner Last Name</label>
                      <input type="text" class="form-control" id="owner_last_name" name="owner_last_name" value="<?php if(isset($owner_last_name)) { echo $owner_last_name; } ?>" />
                    </div>

                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Email*</label>
                      <input type="text" name="email" id="email" class="form-control" value="<?php if(isset($email)) { echo $email; } ?>" >
                      <div class="admin_content_error"><?php echo form_error('email'); ?></div>
                    </div>
                   
                  </div>
                  <div class="form-group  row" data-plugin="formMaterial">
                   <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Password*</label>
                      <input type="password" name="passwd" id="passwd" class="form-control"  />
                      <div class="admin_content_error"><?php echo form_error('passwd'); ?></div>
                    </div>
                  </div>


                  <h3 class="panel-title ">Address</h3>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Street/area*</label>
                      <input type="text" name="address1" id="address1" class="form-control" value="<?php if(isset($address1)) { echo $address1; } ?>" >
                      <div class="admin_content_error"><?php echo form_error('address1'); ?></div>
                    </div>
                    <div class="col-md-6">
                       <label class="form-control-label" for="inputGrid2">City*</label>
                      <input type="text" name="city" id="city" class="form-control" value="<?php if(isset($city)) { echo $city; } ?>"  maxlength="100"  />
                      <div class="admin_content_error"><?php echo form_error('city'); ?></div>
                    </div>
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">State</label>
                      <input type="text" name="state" id="state" class="form-control" value="<?php if(isset($state)) { echo $state; } ?>"  maxlength="100">
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Post Code</label>
                      <input type="text" name="post_code" id="post_code" class="form-control" value="<?php if(isset($post_code)) { echo $post_code; } ?>" >
                    </div>
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Country*</label>
                      <div class="form-group">
                        <select class="form-control" name="country_id" id="country_id">
                          <option>Select Country</option>
                          <?php if($all_countries){?>
                          <?php foreach($all_countries as $country){?>
                           <option <?php if(isset($country_id)){ if($country_id == $country['iso_code']) { echo "selected"; } } ?> value="<?php echo $country['iso_code'];?>"><?php echo $country['name'];?></option>
                          <?php } } ?>
                        </select>
                        <div class="admin_content_error"><?php echo form_error('country_id'); ?></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Currency</label>
                      <div class="form-group">
                        <select name="currency_id" id="currency_id" class="form-control">
                          <?php if($all_currency){?>
                           <?php foreach($all_currency as $currency){?>
                           <option <?php if(isset($currency_id)){ if($currency_id == $currency['id']) { echo "selected"; } } ?> value="<?php echo $currency['id'];?>"><?php echo $currency['symbol']." ".$currency['name'];?></option>
                           <?php } } ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group  row " data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Time zone</label>
                      <select class="form-control" name="time_zone_id" id="time_zone_id">
                          <?php if($time_zones){?>
                           <?php foreach($time_zones as $key => $val) { ?>
                           <option <?php if(isset($time_zone_id)){ if($time_zone_id == $key) { echo "selected"; } } ?> value="<?php echo $key; ?>"><?php echo $val; ?></option>
                           <?php } } ?>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Time Format</label>
                       <div class="form-group">
                        <select name="time_format" id="time_format" class="form-control">
                          <option <?php if(isset($time_format)){ if($time_format == '12-hours') { echo "selected"; } } ?> value="12-hours">12 hours</option>
                          <option <?php if(isset($time_format)){ if($time_format == '24-hours') { echo "selected"; } } ?> value="24-hours">24 hours</option>
                        </select>
                      </div>
                    </div>
                  </div>


                  <h3 class="panel-title ">Business Description</h3>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Description</label>
                      <textarea class="form-control" name="description" id="description" value="<?php if(isset($description)) { echo $description; } ?>"  rows="3"></textarea>
                    </div>
                    <div class="col-md-6">
                      
                    </div>
                  </div>


                  <h3 class="panel-title ">Business Logo</h3>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Business Logo</label>
                      <div class="form-group">
                        <div class="input-group input-group-file" data-plugin="inputGroupFile">
                          <input type="text" class="form-control">
                          <span class="input-group-append">
                          <span class="btn btn-success btn-file">
                            <i class="icon md-upload" aria-hidden="true"></i>
                            <input type="file" name="image" id="logo">
                          </span>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                    </div>
                  </div>


                  <h3 class="panel-title ">Get Social</h3>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Facebook Url</label>
                      <input type="text" class="form-control" name="facebook_url" id="facebook_url" value="<?php if(isset($facebook_url)) { echo $facebook_url; } ?>" >
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Twitter Url</label>
                      <input type="text" class="form-control" id="twitter_url" name="twitter_url" value="<?php if(isset($twitter_url)) { echo $twitter_url; } ?>"   />
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
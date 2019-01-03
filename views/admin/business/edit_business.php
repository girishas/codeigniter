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
	 <?php if($this->session->flashdata('success_msg')) {?>
	   <div class="alert dark alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
		<?php echo $this->session->flashdata('success_msg');?>
	  </div>
	  <?php }else if($this->session->flashdata('error_msg')) { ?>
	  <div class="alert alert-danger alert-dismissible" role="alert">
       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
	   <?php echo $this->session->flashdata('error_msg');?>
       </div>
	<?php  }?>
	<!-- End alert message part -->
	
      <div class="page-content container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Panel Static Labels -->
            <div class="panel">
              <div class="panel-heading">
               <h3 class="panel-title ">Business Details</h3>
				<div class="page-header-actions"><a href="<?php echo base_url('admin/business');?>"><button type="button" class="btn btn-block btn-primary">All Business</button></a></div>
              </div>
              <div class="panel-body container-fluid">
                <form autocomplete="off" method="post" action="" enctype="multipart/form-data">
                  <input type="hidden" name="action" value="save"> 

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php if(isset($business_detail)) { $name = (isset($name) && $name!='')?$name:$business_detail[0]['name']; } else { $name = (isset($name) && $name!='')?$name:''; }?>
                      <label class="form-control-label" for="inputGrid1">Business Name*</label>
                      <input type="text" name="name" id="name" class="form-control" value="<?php if(isset($name)) echo $name; ?>"  >
                      <div class="admin_content_error"><?php echo form_error('name'); ?></div>
                    </div>

                    <div class="col-md-6">
                      <?php if(isset($business_detail)) { $abn_number = (isset($abn_number) && $abn_number!='')?$abn_number:$business_detail[0]['abn_number']; } else { $abn_number = (isset($abn_number) && $abn_number!='')?$abn_number:''; }?>
                      <label class="form-control-label" for="inputGrid1">ABN Number*</label>
                      <input type="text" name="abn_number" id="abn_number" class="form-control" value="<?php if(isset($abn_number)) echo $abn_number; ?>" maxlength="13" >
                      <div class="admin_content_error"><?php echo form_error('abn_number'); ?></div>
                    </div>
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php if(isset($business_detail)) { $website = (isset($website) && $website!='')?$website:$business_detail[0]['website']; } else { $website = (isset($website) && $website!='')?$website:''; }?>
                      <label class="form-control-label" for="inputGrid2">Website</label>
                      <input type="text" class="form-control" id="website" name="website" value="<?php if(isset($website)) echo $website; ?>"  />
                    </div>
                    <div class="col-md-6">
                      <?php if(isset($business_detail)) { $phone_number = (isset($phone_number) && $phone_number!='')?$phone_number:$business_detail[0]['phone_number']; } else { $phone_number = (isset($phone_number) && $phone_number!='')?$phone_number:''; }?>
                      <label class="form-control-label" for="inputGrid2">Phone Number</label>
                      <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?php if(isset($phone_number)) echo $phone_number; ?>"  />
                    </div>
                   
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                     <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Business Category</label>
                      <?php if(isset($business_detail)) { $business_category_id = (isset($business_category_id) && $business_category_id!='')?$business_category_id:$business_detail[0]['business_category_id']; } else { $business_category_id = (isset($business_category_id) && $business_category_id!='')?$business_category_id:''; }?>
                      <div class="form-group">
                        <select class="form-control" name="business_category_id" id="business_category_id">
                          <option>Select Category</option>
                          <?php if($all_categories){?>
                           <?php foreach($all_categories as $cat){?>
                           <option value="<?php echo $cat['id'];?>" <?php if($business_category_id==$cat['id']) echo "selected";?>><?php echo $cat['name'];?></option>
                           <?php } } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <?php if(isset($business_detail)) { $owner_first_name = (isset($owner_first_name) && $owner_first_name!='')?$owner_first_name:$business_detail[0]['owner_first_name']; } else { $owner_first_name = (isset($owner_first_name) && $owner_first_name!='')?$owner_first_name:''; }?>
                      <label class="form-control-label" for="inputGrid1">Owner First Name*</label>
                      <input type="text" class="form-control" id="owner_first_name" name="owner_first_name" value="<?php if(isset($owner_first_name)) echo $owner_first_name; ?>">
                      <div class="admin_content_error"><?php echo form_error('owner_first_name'); ?></div>
                    </div>
                    
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php if(isset($business_detail)) { $email = (isset($email) && $email!='')?$email:$business_detail[0]['email']; } else { $email = (isset($email) && $email!='')?$email:''; }?>
                      <label class="form-control-label" for="inputGrid1">Email*</label>
                      <input type="text" name="email" id="email" class="form-control" value="<?php if(isset($email)) echo $email; ?>">
                      <div class="admin_content_error"><?php echo form_error('email'); ?></div>
                    </div>

                    <div class="col-md-6">
                      <?php if(isset($business_detail)) { $owner_last_name = (isset($owner_last_name) && $owner_last_name!='')?$owner_last_name:$business_detail[0]['owner_last_name']; } else { $owner_last_name = (isset($owner_last_name) && $owner_last_name!='')?$owner_last_name:''; }?>
                      <label class="form-control-label" for="inputGrid2">Owner Last Name</label>
                      <input type="text" class="form-control" id="owner_last_name" name="owner_last_name" value="<?php if(isset($owner_last_name)) echo $owner_last_name; ?>"  />
                    </div>
                  </div>
                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <!-- <?php $passwd_value = (isset($passwd) && $v!='')?$passwd:$business_detail[0]['password'];?> -->
                      <label class="form-control-label" for="inputGrid2">Password*</label>
                      <input type="password" name="passwd" id="passwd" class="form-control" value="" />
                      <div class="admin_content_error"><?php echo form_error('passwd'); ?></div>
                    </div>
                  </div>



                  <h3 class="panel-title ">Address</h3>

                  <div class="form-group  row" data-plugin="formMaterial">              
                    <div class="col-md-6">
                      <?php if(isset($business_detail)) { $address1 = (isset($address1) && $address1!='')?$address1:$business_detail[0]['address1']; } else { $address1 = (isset($address1) && $address1!='')?$address1:''; }?>
                      <label class="form-control-label" for="inputGrid1">Street/area*</label>
                      <input type="text" name="address1" id="address1" class="form-control" value="<?php if(isset($address1)) echo $address1; ?>">
                      <div class="admin_content_error"><?php echo form_error('address1'); ?></div>
                    </div>
                    <div class="col-md-6">
                      <?php if(isset($business_detail)) { $city = (isset($city) && $city!='')?$city:$business_detail[0]['city']; } else { $city = (isset($city) && $city!='')?$city:''; }?>
                      <label class="form-control-label" for="inputGrid2">City*</label>
                      <input type="text" name="city" id="city" class="form-control" value="<?php if(isset($city)) echo $city; ?>" maxlength="100"  />
                      <div class="admin_content_error"><?php echo form_error('city'); ?></div>
                    </div>
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php if(isset($business_detail)) { $state = (isset($state) && $state!='')?$state:$business_detail[0]['state']; } else { $state = (isset($state) && $state!='')?$state:''; }?>
                      <label class="form-control-label" for="inputGrid1">State</label>
                      <input type="text" name="state" id="state" class="form-control" value="<?php if(isset($state)) echo $state; ?>"  maxlength="100">
                    </div>
                    <div class="col-md-6">
                      <?php if(isset($business_detail)) { $post_code = (isset($post_code) && $post_code!='')?$post_code:$business_detail[0]['post_code']; } else { $post_code = (isset($post_code) && $post_code!='')?$post_code:''; }?>
                      <label class="form-control-label" for="inputGrid1">Post Code</label>
                      <input type="text" name="post_code" id="post_code" class="form-control" value="<?php if(isset($post_code)) echo $post_code; ?>">
                    </div>
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php if(isset($business_detail)) { $country_id = (isset($country_id) && $country_id!='')?$country_id:$business_detail[0]['country_id']; } else { $country_id = (isset($country_id) && $country_id!='')?$country_id:''; }?>
                      <label class="form-control-label" for="inputGrid2">Country*</label>
                      <div class="form-group">
                        <select class="form-control" name="country_id" id="country_id">
                          <option>Select Country</option>
                          <?php if($all_countries){?>
                          <?php foreach($all_countries as $country){?>
                           <option value="<?php echo $country['iso_code'];?>" <?php if($country_id==$country['iso_code']) echo "selected";?>><?php echo $country['name'];?></option>
                          <?php } } ?>
                        </select>
                         <div class="admin_content_error"><?php echo form_error('country_id'); ?></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <?php if(isset($business_detail)) { $currency_id = (isset($currency_id) && $currency_id!='')?$currency_id:$business_detail[0]['currency_id']; } else { $currency_id = (isset($currency_id) && $currency_id!='')?$currency_id:''; }?>
                      <label class="form-control-label" for="inputGrid1">Currency</label>
                      <div class="form-group">
                        <select name="currency_id" id="currency_id" class="form-control">
                          <?php if($all_currency){?>
                           <?php foreach($all_currency as $currency){?>
                           <option value="<?php echo $currency['id'];?>" <?php if($currency_id==$currency['id']) echo "selected";?>><?php echo $currency['symbol']." ".$currency['name'];?></option>
                           <?php } } ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">      
                   <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Time zone</label>
                      <?php if(isset($business_detail)) { $time_zone_id = (isset($time_zone_id) && $time_zone_id!='')?$time_zone_id:$business_detail[0]['time_zone_id']; } else { $time_zone_id = (isset($time_zone_id) && $time_zone_id!='')?$time_zone_id:''; }?>
                      <select class="form-control" name="time_zone_id" id="time_zone_id">
                          <?php if($time_zones){?>
                           <?php foreach($time_zones as $key => $val) { ?>
                           <option <?php if(isset($time_zone_id)){ if($time_zone_id == $key) { echo "selected"; } } ?> value="<?php echo $key; ?>"><?php echo $val; ?></option>
                           <?php } } ?>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <?php if(isset($business_detail)) { $time_format = (isset($time_format) && $time_format!='')?$time_format:$business_detail[0]['time_format']; } else { $time_format = (isset($time_format) && $time_format!='')?$time_format:''; }?>
                      <label class="form-control-label" for="inputGrid1">Time Format</label>
                      <div class="form-group">
                        <select name="time_format" id="time_format" class="form-control">
                          <option value="12-hours" <?php if($time_format=="12-hours") echo "selected";?>>12 hours</option>
                          <option value="24-hours" <?php if($time_format=="24-hours") echo "selected";?>>24 hours</option>
                        </select>
                      </div>
                    </div>
                  </div>



                  <h3 class="panel-title ">Business Description</h3>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php if(isset($business_detail)) { $description = (isset($description) && $description!='')?$description:$business_detail[0]['description']; } else { $description = (isset($description) && $description!='')?$description:''; }?>
                      <label class="form-control-label" for="inputGrid1">Description</label>
                      <textarea class="form-control" name="description" id="description" rows="3"><?php echo $description;?></textarea>
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
                        <?php if(!empty($business_detail[0]['logo'])){?>
                          <img id="img_1" src="<?php echo base_url('images/staff/thumb/'.$business_detail[0]['logo']); ?>" width="50px;" style="margin-top:2px;" />
                          <?php }else{?>
                          <img id="img_1" class="img-fluid" src="<?php echo base_url('global/product/no-product-image.jpg');?>" width="50px;" style="margin-top:2px;">
                        <?php }?>
                      </div>
                    </div>
                    <div class="col-md-6">
                    </div>
                  </div>



                  <h3 class="panel-title ">Get Social</h3>

                  <div class="form-group  row" data-plugin="formMaterial">
                   
                    <div class="col-md-6">
                      <?php if(isset($business_detail)) { $facebook_url = (isset($facebook_url) && $facebook_url!='')?$facebook_url:$business_detail[0]['facebook_url']; } else { $facebook_url = (isset($facebook_url) && $facebook_url!='')?$facebook_url:''; }?>
                      <label class="form-control-label" for="inputGrid1">Facebook Url</label>
                      <input type="text" class="form-control" name="facebook_url" id="facebook_url" value="<?php if(isset($facebook_url)) echo $facebook_url; ?>">
                    </div>
                    <div class="col-md-6">
                      <?php if(isset($business_detail)) { $twitter_url = (isset($twitter_url) && $twitter_url!='')?$twitter_url:$business_detail[0]['twitter_url']; } else { $twitter_url = (isset($twitter_url) && $twitter_url!='')?$twitter_url:''; }?>
                      <label class="form-control-label" for="inputGrid2">Twitter Url</label>
                      <input type="text" class="form-control" id="twitter_url" name="twitter_url" value="<?php if(isset($twitter_url)) echo $twitter_url; ?>"   />
                    </div>
                  </div>

                  <!-- <div class="form-group  row" data-plugin="formMaterial">
                    <?php $name_value = (isset($name) && $name!='')?$name:$business_detail[0]['name'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Business Name*</label>
                      <input type="text" name="name" id="name" class="form-control" value="<?php if(isset($name_value)) echo $name_value; ?>"  >
					  <div class="admin_content_error"><?php echo form_error('name'); ?></div>
                    </div>
                   <?php $phone_number_value = (isset($phone_number) && $phone_number!='')?$phone_number:$business_detail[0]['phone_number'];?>
				    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Phone Number</label>
                      <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?php if(isset($phone_number_value)) echo $phone_number_value; ?>"  />
                    </div>
                  </div>
				  
				  <div class="form-group  row" data-plugin="formMaterial">
                    <?php $email_value = (isset($email) && $email!='')?$email:$business_detail[0]['email'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Email*</label>
                      <input type="text" name="email" id="email" class="form-control" value="<?php if(isset($email_value)) echo $email_value; ?>">
					  <div class="admin_content_error"><?php echo form_error('email'); ?></div>
                    </div>
                    <?php $passwd_value = (isset($passwd) && $v!='')?$passwd:$business_detail[0]['password'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Password*</label>
                      <input type="text" name="passwd" id="passwd" class="form-control" value="<?php if(isset($passwd_value)) echo $passwd_value; ?>" />
					  <div class="admin_content_error"><?php echo form_error('passwd'); ?></div>
                    </div>
                  </div>
				  
				   <div class="form-group  row" data-plugin="formMaterial">
                    <?php $address1_value = (isset($address1) && $address1!='')?$address1:$business_detail[0]['address1'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Street/area*</label>
                      <input type="text" name="address1" id="address1" class="form-control" value="<?php if(isset($address1_value)) echo $address1_value; ?>">
					  <div class="admin_content_error"><?php echo form_error('address1'); ?></div>
                    </div>
                    <?php $city_value = (isset($city) && $city!='')?$city:$business_detail[0]['city'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">City*</label>
                      <input type="text" name="city" id="city" class="form-control" value="<?php if(isset($city_value)) echo $city_value; ?>" maxlength="100"  />
					  <div class="admin_content_error"><?php echo form_error('city'); ?></div>
                    </div>
                  </div>
				  
				  <div class="form-group  row" data-plugin="formMaterial">
                    <?php $state_value = (isset($state) && $state!='')?$state:$business_detail[0]['state'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">State</label>
                      <input type="text" name="state" id="state" class="form-control" value="<?php if(isset($state_value)) echo $state_value; ?>"  maxlength="100">
                    </div>
                    <?php $country_id_value = (isset($country_id) && $country_id!='')?$country_id:$business_detail[0]['country_id'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Country*</label>
                      <div class="form-group">
						<select class="form-control" name="country_id" id="country_id">
						  <option>Select Country</option>
						  <?php if($all_countries){?>
						  <?php foreach($all_countries as $country){?>
						   <option value="<?php echo $country['iso_code'];?>" <?php if($country_id_value==$country['iso_code']) echo "selected";?>><?php echo $country['name'];?></option>
						  <?php } } ?>
						</select>
						 <div class="admin_content_error"><?php echo form_error('country_id'); ?></div>
					  </div>
                    </div>
                  </div>
				  <div class="form-group  row" data-plugin="formMaterial">
                    <?php $post_code_value = (isset($post_code) && $post_code!='')?$post_code:$business_detail[0]['post_code'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Post Code</label>
                      <input type="text" name="post_code" id="post_code" class="form-control" value="<?php if(isset($post_code_value)) echo $post_code_value; ?>">
                    </div>
                    <?php $business_category_id_value = (isset($business_category_id) && $business_category_id!='')?$business_category_id:$business_detail[0]['business_category_id'];?>
				    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Business Category</label>
                      <div class="form-group">
						<select class="form-control" name="business_category_id" id="business_category_id">
						  <option>Select Category</option>
						  <?php if($all_categories){?>
						   <?php foreach($all_categories as $cat){?>
						   <option value="<?php echo $cat['id'];?>" <?php if($business_category_id_value==$cat['id']) echo "selected";?>><?php echo $cat['name'];?></option>
						   <?php } } ?>
						</select>
					  </div>
                    </div>
                  </div>
				  
				  <div class="form-group  row" data-plugin="formMaterial">
                    <?php $currency_id_value = (isset($currency_id) && $currency_id!='')?$currency_id:$business_detail[0]['currency_id'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Currency</label>
                      <div class="form-group">
						<select name="currency_id" id="currency_id" class="form-control">
						  <?php if($all_currency){?>
						   <?php foreach($all_currency as $currency){?>
						   <option value="<?php echo $currency['id'];?>" <?php if($currency_id_value==$currency['id']) echo "selected";?>><?php echo $currency['symbol'];?></option>
						   <?php } } ?>
						</select>
					  </div>
                    </div>
                    <?php $time_zone_id_value = (isset($time_zone_id) && $time_zone_id!='')?$time_zone_id:$business_detail[0]['time_zone_id'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Time zone</label>
                      <input type="text" name="time_zone_id" id="time_zone_id" class="form-control" value="<?php if(isset($time_zone_id_value)) echo $time_zone_id_value; ?>" />
                    </div>
                  </div>
				  <div class="form-group  row" data-plugin="formMaterial">
                    <?php $time_format_value = (isset($time_format) && $time_format!='')?$time_format:$business_detail[0]['time_format'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Time Format</label>
                       <div class="form-group">
						<select name="time_format" id="time_format" class="form-control">
						  <option value="12-hours" <?php if($time_format_value=="12-hours") echo "selected";?>>12 hours</option>
						  <option value="24-hours" <?php if($time_format_value=="24-hours") echo "selected";?>>24 hours</option>
						</select>
					  </div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Business Logo</label>
                      <div class="form-group">
						<div class="input-group input-group-file" data-plugin="inputGroupFile">
						  <input type="text" class="form-control">
						  <span class="input-group-append">
							<span class="btn btn-success btn-file">
							  <i class="icon md-upload" aria-hidden="true"></i>
							  <input type="file" name="logo" id="logo">
							</span>
						  </span>
						</div>
					  </div>
                    </div>
                  </div>
				  
				  <div class="form-group  row" data-plugin="formMaterial">
                   <?php $facebook_url_value = (isset($facebook_url) && $facebook_url!='')?$facebook_url:$business_detail[0]['facebook_url'];?>
				    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Facebook Url</label>
                      <input type="text" class="form-control" name="facebook_url" id="facebook_url" value="<?php if(isset($facebook_url_value)) echo $facebook_url_value; ?>">
                    </div>
                   <?php $twitter_url_value = (isset($twitter_url) && $twitter_url!='')?$twitter_url:$business_detail[0]['twitter_url'];?>
				    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Twitter Url</label>
                      <input type="text" class="form-control" id="twitter_url" name="twitter_url" value="<?php if(isset($twitter_url_value)) echo $twitter_url_value; ?>"   />
                    </div>
                  </div>
				  
				   <div class="form-group  row" data-plugin="formMaterial">
                    <?php $description_value = (isset($description) && $description!='')?$description:$business_detail[0]['description'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Description</label>
                      <textarea class="form-control" name="description" id="description" rows="3"><?php echo $description_value;?></textarea>
                    </div>
					<?php $website_value = (isset($website) && $website!='')?$name:$business_detail[0]['website'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Website</label>
                      <input type="text" class="form-control" id="website" name="website" value="<?php if(isset($website_value)) echo $website_value; ?>"  />
                    </div>
                  </div>
				  
				  <div class="form-group  row" data-plugin="formMaterial">
                    <?php $owner_first_name_value = (isset($owner_first_name) && $owner_first_name!='')?$owner_first_name:$business_detail[0]['owner_first_name'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Owner First Name*</label>
                      <input type="text" class="form-control" id="owner_first_name" name="owner_first_name" value="<?php if(isset($owner_first_name_value)) echo $owner_first_name_value; ?>">
					  <div class="admin_content_error"><?php echo form_error('owner_first_name'); ?></div>
                    </div>
                    <?php $owner_last_name_value = (isset($owner_last_name) && $owner_last_name!='')?$owner_last_name:$business_detail[0]['owner_last_name'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Owner Last Name</label>
                      <input type="text" class="form-control" id="owner_last_name" name="owner_last_name" value="<?php if(isset($owner_last_name_value)) echo $owner_last_name_value; ?>"  />
                    </div>
                  </div> -->
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